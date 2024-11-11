<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Sgd\Models\Ciudadano;
use App\Http\Controllers\Sgd\Models\PersonaJuridica;
use App\Http\Controllers\Seguridad\Models\Usuario;
use Session;

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        // dd($request);
        $TIPO_PERSONA = $request->input('P_TIPO_PERSONA');
        $RUC = $request->input('P_RUC');
        $DNI = $request->input('P_NRO_DOCUMENTO');
        $CLAVE = $request->input('P_CLAVE');

        $request->validate([
            'P_TIPO_PERSONA' => 'required|in:1,2',
            'P_RUC' => 'nullable|string|max:11',
            'P_NRO_DOCUMENTO' => 'nullable|string|max:12',
            'P_CLAVE' => 'required|string',
        ]);
        $NRO_USUARIO = ($TIPO_PERSONA == '1') ? $DNI : $RUC;

        $USUARIO = Usuario::where('USU_NUMERO_DOCUMENTO', $NRO_USUARIO)->first();

        if (!$USUARIO || !Hash::check($CLAVE, $USUARIO->USU_CLAVE)) {
            return back()->with('error', 'Las credenciales proporcionadas son incorrectas.');
        }
        $persmisos = $USUARIO->getPermisos();

        $this->navbar($persmisos);

        session(['user' => $USUARIO]);
        return redirect('/dashboard');
    }
    public function store(Request $request)
    {
        $P_TIPO_PERSONA = $request->input('P_TIPO_PERSONA');
        $P_RUC = $request->input('P_RUC');
        $P_RAZON_SOCIAL = $request->input('P_RAZON_SOCIAL');
        $P_DIRECCION_EMPRESA = $request->input('P_DIRECCION_EMPRESA');
        $P_NRO_DOCUMENTO = $request->input('P_NRO_DOCUMENTO');
        $P_APELLIDO_PARTERNO = $request->input('P_APELLIDO_PARTERNO');
        $P_APELLIDO_MATERNO = $request->input('P_APELLIDO_MATERNO');
        $P_NOMBRES = $request->input('P_NOMBRES');
        $P_DIRECCION_PERSONA = $request->input('P_DIRECCION_PERSONA');
        $P_CLAVE = $request->input('P_CLAVE');
        $P_CLAVE_CONFIRM = $request->input('P_CLAVE_CONFIRM');
        // $ACEPTA_TERMINO = $request->checkbox('ACEPTA_TERMINO');

        $USUARIO = ($P_TIPO_PERSONA == '1') ? $P_NRO_DOCUMENTO : $P_RUC;

        if ($P_CLAVE_CONFIRM != $P_CLAVE) {
            // dd($P_CLAVE_CONFIRM, $P_CLAVE);
            return back()->with('error', 'Las contraseñas deben de coincidir');
        }

        $user_exist = Usuario::where('USU_NUMERO_DOCUMENTO', $USUARIO)->first();
        if ($user_exist) {
            // dd($user_exist->id);
            return back()->with('error', 'El usuario ya existe');
            // return response()->json(['error' => 'El usuario ya existe.'], 409);
        }
        $personaNatural = new Usuario();

        $this->asignarAtributosRepetidos($personaNatural, $request);
        if ($P_TIPO_PERSONA === '2') {
            $personaJuridica = new Usuario();

            $this->asignarAtributosRepetidos($personaJuridica, $request);
            $personaJuridica->USU_NUMERO_DOCUMENTO = $P_RUC;
            $personaJuridica->USU_DIRECCION = trim($P_DIRECCION_EMPRESA);
            $personaJuridica->USU_RAZON_SOCIAL = trim($P_RAZON_SOCIAL);
            // Registrar la presona juridica
            $personaJuridica->save();
            // Registrar persona juridica en el SGD 
            $this->registrarPersonaJuridica($personaJuridica);
            $personaNatural->ID_REPRESENTANTE = $personaJuridica->USU_ID;
        }

        $personaNatural->USU_RAZON_SOCIAL = $P_APELLIDO_PARTERNO . ' ' . $P_APELLIDO_MATERNO . ' ' . $P_NOMBRES;
        $personaNatural->USU_APE_PATERNO = trim($P_APELLIDO_PARTERNO);
        $personaNatural->USU_APE_MATERNO = trim($P_APELLIDO_MATERNO);
        $personaNatural->USU_NOMBRES = trim($P_NOMBRES);
        $personaNatural->USU_DIRECCION = trim($P_DIRECCION_PERSONA);
        $personaNatural->USU_NUMERO_DOCUMENTO = $P_NRO_DOCUMENTO;

        // REGISTRA LA PERSONA EN LA TABLA CIUDADANO
        $this->registrarCiudadano($personaNatural);
        $personaNatural->save();
        return redirect('/')->with('ok', 'Usuario registrado exitosamente.');
    }
    private function asignarAtributosRepetidos($usuario, $request)
    {
        $usuario->USU_TIPO_PERSONA = $request->input('P_TIPO_PERSONA');
        $usuario->USU_TIPO_DOCUMENTO = $request->input('P_TIPO_DOCUMENTO');
        $usuario->USU_IND_ESTADO = '1';
        $usuario->USU_CLAVE = Hash::make($request->input('P_CLAVE'));
        $usuario->USU_FEC_REGISTRO = now()->format('Y-m-d H:i:s');
        $usuario->USU_FEC_MODIFICACION = now()->format('Y-m-d H:i:s');
        $usuario->USU_NU_CELULAR = $request->input('P_CELULAR');
        $usuario->USU_CORREO = $request->input('P_CORREO');
        $usuario->USU_DEPARTAMENTO = $request->input('P_DEPARTAMENTO');
        $usuario->USU_PROVINCIA = $request->input('P_PROVINCIA');
        $usuario->USU_DISTRITO = $request->input('P_DISTRITO');
        $usuario->ID_ROLES = '1';
    }
    private function registrarCiudadano($usuario)
    {
        $ciudadano = new Ciudadano();
        $ciudadano->NULEM = $usuario->USU_NUMERO_DOCUMENTO;
        $ciudadano->UBDEP = $usuario->USU_DEPARTAMENTO;
        $ciudadano->UBPRV = $usuario->USU_PROVINCIA;
        $ciudadano->UBDIS = $usuario->USU_DISTRITO;
        $ciudadano->DEAPP = $usuario->USU_APE_PATERNO;
        $ciudadano->DEAPM = $usuario->USU_APE_MATERNO;
        $ciudadano->DENOM = $usuario->USU_NOMBRES;
        $ciudadano->DEDOMICIL = $usuario->USU_DIRECCION;
        $ciudadano->DEEMAIL = $usuario->USU_CORREO;
        $ciudadano->DETELEFO = $usuario->USU_NU_CELULAR;
        try {
            $ciudadano->save();
        } catch (\Exception $e) {
            // Manejo de excepciones
            return response()->json(['error', 'Ocurrio un problema al registrar el ciudadano']);
            // return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function registrarPersonaJuridica($personaJuridica)
    {
        $juridica = new PersonaJuridica();
        $juridica->CPRO_RUC = $personaJuridica->USU_NUMERO_DOCUMENTO;
        $juridica->CPRO_RAZSOC = $personaJuridica->USU_RAZON_SOCIAL;
        $juridica->DPRO_FECINS = $personaJuridica->USU_FEC_REGISTRO;
        $juridica->CPRO_DOMICIL = $personaJuridica->USU_DIRECCION;
        $juridica->CPRO_EMAIL = $personaJuridica->USU_CORREO;
        $juridica->CUBI_CODDEP = $personaJuridica->USU_DEPARTAMENTO;
        $juridica->CUBI_CODPRO = $personaJuridica->USU_PROVINCIA;
        $juridica->CUBI_CODDIS = $personaJuridica->USU_DISTRITO;
        try {
            $juridica->save();
        } catch (\Exception $e) {
            return response()->json(['error', 'Ocurrio un problema al registrar el ciudadano']);
            // return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function navbar($menuGlobal)
    {
        $html = '';
        $tipo = null;
        foreach ($menuGlobal as $row_op) {
            // Si es leyenda
            if ($row_op->OPCI_TIPO == 1) {
                $html .= '<li class="menu-label mt-0">' . $row_op->OPCI_NOMBRE . '</li>';
            }

            // Si es menú de primer nivel
            elseif ($row_op->OPCI_TIPO == 2 && $row_op->OPCI_SUB_CODIGO == 1) {
                $subMenus = array_filter($menuGlobal, function ($item) use ($row_op) {
                    return $item->OPCI_TIPO == 2 && $item->OPCI_SUB_CODIGO == $row_op->OPCI_CODIGO;
                });

                if (!empty($subMenus)) {
                    $html .= '<li>
                                <a href="javascript: void(0);" aria-expanded="false">
                                    <span>' . $row_op->OPCI_ICON . ' ' . $row_op->OPCI_NOMBRE . '</span>
                                    <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span>
                                </a>
                                <ul class="nav-second-level mm-collapse" aria-expanded="false" style="height: 0px;">';

                    foreach ($subMenus as $subMenu) {
                        $html .= '<li><a href="' . URL('/') . '/' . $subMenu->OPCI_HREF . '"><i class="ti-control-record"></i>' . $subMenu->OPCI_NOMBRE . '</a></li>';
                    }

                    $html .= '</ul></li>';
                } else {
                    // Si no tiene submenús, solo se agrega como enlace simple
                    $html .= '<li><a href="' . URL('/') . '/' . $row_op->OPCI_HREF . '"><span>' . $row_op->OPCI_ICON . ' ' . $row_op->OPCI_NOMBRE . '</span></a></li>';
                }
            }
        }   
        // dd( $html);
        // foreach($menuGlobal as $row_op2):
        //     if($row_op2->OPCI_TIPO==1):
        //         $Submenu=0;
        //             foreach ($menuGlobal as $cantSubmenu):
        //                 if($cantSubmenu->OPCI_TIPO==2 && $cantSubmenu->OPCI_SUB_CODIGO==$row_op2->OPCI_CODIGO):
        //                     $Submenu++;
        //                 endif;
        //             endforeach;

        //             if($Submenu>0):
        //                 $html .='
        //                     <li class="has-submenu">
        //                         <a href="#">                                
        //                             <span><i data-feather="grid" class="align-self-center hori-menu-icon"></i>'.$row_op2->OPCI_NOMBRE.'</span>
        //                         </a>
        //                         <ul class="submenu">';


        //                         foreach ($menuGlobal as $row_op3):
        //                             if($row_op3->OPCI_TIPO==2 && $row_op3->OPCI_SUB_CODIGO==$row_op2->OPCI_CODIGO){
        //                                 $contaOpc=0;
        //                                 foreach ($menuGlobal as $cantidad):
        //                                     if($cantidad->OPCI_TIPO==3 && $cantidad->OPCI_SUB_CODIGO==$row_op3->OPCI_CODIGO):
        //                                         $contaOpc++;
        //                                     endif;
        //                                 endforeach;

        //                                 if($contaOpc<1){  
        //                                     $html .='<li><a href="'.URL('/').'/'.$row_op3->OPCI_HREF.'"><i class="ti ti-minus"></i>'.$row_op3->OPCI_NOMBRE.'</a></li>';

        //                                 }else{
        //                                     $html .='<li class="has-submenu">
        //                                                 <a href="#"><i class="ti ti-minus"></i>'.$row_op3->OPCI_NOMBRE.'</a>
        //                                                 <ul class="submenu">';
        //                                                 foreach ($menuGlobal as $row_op4):
        //                                                     if($row_op4->OPCI_TIPO==3 && $row_op4->OPCI_SUB_CODIGO==$row_op3->OPCI_CODIGO):
        //                                                         $html .='<li><a href="'.URL('/').'/'.$row_op4->OPCI_HREF.'"><i class="ti ti-minus"></i>'.$row_op4->OPCI_NOMBRE.'</a></li>';
        //                                                     endif;
        //                                                 endforeach;
        //                                         $html .='</ul>
        //                                             </li>';
        //                                 }
        //                             }
        //                         endforeach;

        //                 $html .='</ul>
        //                     </li>';
        //             else:
        //                 $html .='<li class="has-submenu">
        //                         <a href="'.URL('/').'/'.$row_op2->OPCI_HREF.'">
        //                             <span><i data-feather="layers" class="align-self-center hori-menu-icon"></i>'.$row_op2->OPCI_NOMBRE.'</span>
        //                         </a>                               
        //                     </li>';
        //             endif;



        //     endif;
        // endforeach;


        $scriptAcceso = '<script>
			$(document).ready(function() {';
            foreach ($menuGlobal as $objetos):
                if ($objetos->OPCI_TIPO == 4):
                    $scriptAcceso .= '$("' . $objetos->OPCI_HREF . '").removeClass("d-none")';
                endif;
            endforeach;
        
            $scriptAcceso .= '})
		</script>';

        // VALIDAMOS SOLO SUS URL
        $ACCESOS = array();
        foreach ($menuGlobal as $url):
            if ($url->OPCI_TIPO != 5 && $url->OPCI_HREF != ''):
                $data = array(
                    $url->OPCI_HREF
                );
                $ACCESOS[] = $data;
            endif;
        endforeach;
        session(['SESS_USUA_ACCESOS' => $ACCESOS]);
        session(['SESS_NAVBAR' => $html]);
        session(['SESS_ACCESOS' => $scriptAcceso]);
    }

    public function perfilIndex(){

        $page_data['header_js'] = array(
            'js/jquery.min.js',
            'js/js_general.js', 
            'plugins/dropify/js/dropify.min.js',
            'pages/jquery.form-upload.init.js',
            'pages/jquery.validation.init.js',
            'plugins/parsleyjs/parsley.min.js',
            'js/metismenu.min.js'
        );
        $page_data['header_css'] = array(
            'plugins/dropify/css/dropify.min.css',
            'css/style.css'
        );
        $page_data['page_directory'] = 'seguridad'; // carpeta
        $page_data['page_name'] = 'perfil'; // nombre carpeta
        $page_data['page_title'] = 'Perfil';
        $page_data['breadcrumb'] = 'Perfil';
        
        return view('index',$page_data);
    }
    public function usuarioRepresentante(){
        
        $USUARIO = session('user');
        if(session('user')->USU_TIPO_PERSONA == 2){
            $DATA = array(
                'usuario' => $USUARIO
            );
        }
        $REPRESENTANTE = Usuario::where('ID_REPRESENTANTE', session('user')->REPRESENTANTE); 
        
        return response()->json($USUARIO,$REPRESENTANTE);
    }
    public function ActualizarPerfil(){

    }

    public function logout()
    {
        // Invalida la sesión actual
        session()->invalidate();
        // Limpiar la sesión actual y regenerar el token
        session()->regenerate();
        return redirect('/')
            ->with('success', 'Has cerrado sesión exitosamente.')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
            ]);
    }
}
