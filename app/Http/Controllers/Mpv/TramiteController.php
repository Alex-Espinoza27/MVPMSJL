<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mpv\Models\Anexo;
use App\Http\Controllers\Mpv\Models\ArchivoPrincipal;
use App\Http\Controllers\Mpv\Models\Estado;
use App\Http\Controllers\Mpv\Models\Solicitud;
use App\Http\Controllers\Mpv\Models\TipoDocumento;
use App\Http\Controllers\Seguridad\Models\Usuario;
use App\Http\Controllers\Sgd\Models\Tupa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TramiteController extends Controller
{
    // public function __construct()
    // {        


    //     try {
    //         $estados = Estado::all();  
    //         dd($estados); 
    //     } catch (\Exception $e) {
    //         dd(['error', $e->getMessage()]); 
    //     }
    // }

    public function solicitudIndex()
    {
        // dd("entro");
        $page_data['header_js'] = array(
            // select2 
            // 'js/js_general.js',
            'js/js_solicitud.js',
            //table
            'plugins/datatables/jquery.dataTables.min.js',
            'plugins/datatables/dataTables.bootstrap5.min.js',
            'pages/jquery.datatable.init.js',
            // repetir anexos
            'plugins/repeater/jquery.repeater.min.js',
            'pages/jquery.form-repeater.js',
            // cargar archivos
            'plugins/dropify/js/dropify.min.js',
            'pages/jquery.form-upload.init.js',
            // form validation 
            'pages/jquery.validation.init.js',
            'plugins/parsleyjs/parsley.min.js',
            //tablas
            'plugins/datatables/dataTables.buttons.min.js',
            'plugins/datatables/buttons.bootstrap5.min.js',
        );

        $page_data['header_css'] = array(
            // select2 - table
            // 'plugins/select2/select2.min.css',
            'plugins/datatables/dataTables.bootstrap5.min.css',
            'plugins/datatables/buttons.bootstrap5.min.css',
            // cargar archivos
            'plugins/dropify/css/dropify.min.css',
            // 'plugins/jvectormap/jquery-jvectormap-2.0.2.css',
            'plugins/datatables/responsive.bootstrap4.min.css',
        );
        $page_data['page_directory'] = 'tramite'; // carpeta
        $page_data['page_name'] = 'solicitud'; // nombre carpeta
        $page_data['page_title'] = 'Mis Tramites';
        $page_data['breadcrumb'] = 'solicitud';

        // dd($SOLICITUDES);
        return view('index', $page_data, );
    }

    public function listarSolicitud()
    {
        $USUARIO = session('user');
        $SOLICITUDES = DB::select('EXEC MDSJL.MOSTRAR_SOLICITUDES @NUMERO_DOCUMENTO_PERSONA = ?', [$USUARIO->USU_NUMERO_DOCUMENTO]);
        // dd($SOLICITUDES);
        return response()->json($SOLICITUDES);

    }
    public function listarSolicitudComoTramitador()
    {
        $USUARIO = session('user');
        $SOLICITUDES = DB::select('EXEC MDSJL.MOSTRAR_SOLICITUDES @NUMERO_DOCUMENTO_PERSONA = ?,@TIPO_LISTADO_ROL = ? ', [$USUARIO->USU_NUMERO_DOCUMENTO,$USUARIO->ID_ROLES]);
        // dd($SOLICITUDES);
        return response()->json($SOLICITUDES);

    }

    public function solictudID($solicitudID)
    {
        // dd("ingreso", $solicitudID);
        try {
            $solicitud = Solicitud::Where('SOLI_ID', $solicitudID)->first();
            $estado = Estado::where('ESTA_ID', $solicitud->SOLI_ESTADO_ID)->first();
            $persona = Usuario::Where('USU_ID', $solicitud->COD_USUARIO)->first();
            $archivoPrincipal = ArchivoPrincipal::Where('SOLICITUD_ID', $solicitud->SOLI_ID)->first();
            $anexos = Anexo::Where('SOLICITUD_ID', $solicitud->SOLI_ID)->get();

            $data['solicitud'] = $solicitud;
            $data['estado'] = $estado;
            $data['solicitante'] = $persona;
            $data['archivoPrincipal'] = $archivoPrincipal;
            $data['anexos'] = $anexos;

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocurrio un problema, no se encontro la solicitud o el estado']);
        }
    }

    public function tupa()
    {
        $tupa = Tupa::all();
        return response()->json($tupa);
    }
    public function tipoDocumento()
    {
        $tipoDocumento = TipoDocumento::all();
        return response()->json($tipoDocumento);
    }
    public function estadoDocumento()
    {
        $estados = Estado::all();
        return response()->json($estados);
    }

    public function correlativoSiguiente()
    {

    }
    public function registrarSolicitud(Request $request)
    {
        // dd($request);
        // $P_ANIO_EXPEDIENTE = $request->input('P_ANIO_EXPEDIENTE');
        $P_TUPA = $request->input('P_TUPA');
        $P_PLAZO_TUPA = $request->input('P_PLAZO_TUPA');
        $P_TIPO_DOCUMENTO = $request->input('P_TIPO_DOCUMENTO');
        $P_NRO_DOCUMENTO = $request->input('P_NRO_DOCUMENTO');
        $P_NRO_FOLIOS = $request->input('P_NRO_FOLIOS');
        $P_ASUNTO = $request->input('P_ASUNTO');

        $SOLICITUD = new Solicitud();


        $CORRELATIVO_ACTUAL = Solicitud::where('COD_USUARIO', session('user')->USU_ID)
            ->where('SOLI_NU_EMI', 'LIKE', 'SOL-' . now()->format('Y') . '%')
            ->orderBy('SOLI_NU_EMI', 'desc')
            ->first();

        if ($CORRELATIVO_ACTUAL) {
            // Extraer el número del correlativo con una expresión regular
            preg_match('/SOL-(\d{4})-(\d{5})/', $CORRELATIVO_ACTUAL->SOLI_NU_EMI, $matches);

            if (isset($matches[2])) {
                // Extraer el número correlativo y aumentarlo
                $correlativo = (int) $matches[2];  // El número de correlativo (ej. 00006)
                $correlativoSiguiente = str_pad($correlativo + 1, 5, '0', STR_PAD_LEFT);  // Incrementar y formatear
            }
        } else {
            // Si no existe un correlativo previo, se asigna el primer correlativo del año
            $correlativoSiguiente = '00001';
        }
 
        $NU_EMI ='SOL-' . now()->format('Y'). '-' . $correlativoSiguiente;         

        if ($P_TUPA != 0) {
            $SOLICITUD->SOLI_COD_TUPA = $P_TUPA;
        }

        $SOLICITUD->SOLI_NU_EMI = $NU_EMI;
        $SOLICITUD->SOLI_NU_ANN =  now()->format('Y');

        // $SOLICITUD->SOLI_FECHA_EMISION = now()->format('Y-m-d H:i:s'); // esto se registra al sgd
        $SOLICITUD->SOLI_FECHA = now()->format('Y-m-d H:i:s');
        // $SOLICITUD->SOLI_NRO_EXPEDIENTE = $P_NRO_EXPEDIENTE;

        // este campo se puede pasar EXPEDIENTE SOLICITUD -> el numero puede volar
        $SOLICITUD->TIPO_DOCUMENTO_ID = $P_TIPO_DOCUMENTO;
        $SOLICITUD->SOLI_NUMERO_DOCUMENTO = $P_NRO_DOCUMENTO;
        $SOLICITUD->SOLI_ASUNTO = $P_ASUNTO;
        $SOLICITUD->SOLI_FOLIOS = $P_NRO_FOLIOS;
        $SOLICITUD->CREATED_AT = now()->format('Y-m-d H:i:s');
        $SOLICITUD->UPDATED_AT = now()->format('Y-m-d H:i:s');
        // $SOLICITUD->DELETED_AT = 
        $SOLICITUD->CREATED_BY = session('user')->USU_NUMERO_DOCUMENTO;
        $SOLICITUD->UPDATED_BY = session('user')->USU_NUMERO_DOCUMENTO;
        $SOLICITUD->COD_USUARIO = session('user')->USU_ID;
        $SOLICITUD->SOLI_ESTADO_ID = 1; //PRESENTADO

        try {
            $SOLICITUD->save();
            $mensaje = $this->guardarArchivos($request,  $NU_EMI,$SOLICITUD->SOLI_ID);
            return redirect('/tramite/solicitud')->with($mensaje['tipo'], $mensaje['mensaje']);
        } catch (\Exception $e) {
            return ['error', $e->getMessage()];
            // return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // se usa en observados
    public function guardarArchivosPlantilla($archivo, $usuario, $solicitudId, $carpeta)
    {
        //1. Ruta base para crear los archivos
        $BASE_PATH_MPV = 'public/ArchivosMPV';
        $USUARIO = $usuario;
        $ARCHIVO_PRIN_FOLDER = $carpeta; //observado
        $CORRELATIVO = Solicitud::where('SOLI_NU_EMI', $solicitudId)
        ->select('SOLI_NU_EMI')->first();

        // 2. Crear estructura de directorios
        $USUARIO_PATH = "{$BASE_PATH_MPV}/{$USUARIO}/{$CORRELATIVO}";
        $ARCHIVO_PRINCIPAL_PATH = "{$USUARIO_PATH}/{$ARCHIVO_PRIN_FOLDER}";
        $ARCHIVO_PRINCIPAL = $archivo;
        $NOMBRE_ARCHIVOS_PRINCIPAL = $this->limpiarNombreArchivo($ARCHIVO_PRINCIPAL->getClientOriginalName());

        //dd($USUARIO_PATH,$ARCHIVO_PRINCIPAL_PATH);
        foreach ([$USUARIO_PATH, $ARCHIVO_PRINCIPAL_PATH] as $PATH) {
            if (!Storage::exists($PATH)) {
                Storage::makeDirectory($PATH);
            }
        }
        try {
            $RUTA_ARCHIVO = Storage::putFileAs(
                $ARCHIVO_PRINCIPAL_PATH,
                $ARCHIVO_PRINCIPAL,
                $NOMBRE_ARCHIVOS_PRINCIPAL
            );
            return $RUTA_ARCHIVO;
        } catch (\Throwable $th) {
            return 'error';
        }
    }
    public function guardarArchivos(Request $request,$NU_EMI, $SOLICITUD_ID)
    {
        try {
            $validator = Validator::make($request->all(), [
                'P_ARCHIVO_PRIN' => 'required|file|mimes:pdf|max:51200', // 10MB máximo
                'LIST_ANEXOS.*.P_ANEXOS' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30000'
            ]);

            if ($validator->fails()) {
                return ['tipo' => 'error', 'mensaje' => 'Fatal' . $validator->errors()];
            }

            //sale  hasta la ruta http::/
            // ../../storage/app/public/ArchivosMPV
            // $BASE_PATH_MPV = '../../storage/app/public/archivosMPV';
            $BASE_PATH_MPV = 'public/archivosMPV';
            $USUARIO = session('user')->USU_NUMERO_DOCUMENTO;
            $ARCHIVO_PRIN_FOLDER = 'archivo_principal';
            $ANEXOS_FOLDER = 'anexos';

            // 3. Crear estructura de directorios
            $USUARIO_PATH = "{$BASE_PATH_MPV}/{$USUARIO}/{$NU_EMI}";
            $ARCHIVO_PRINCIPAL_PATH = "{$USUARIO_PATH}/{$ARCHIVO_PRIN_FOLDER}";
            $ANEXOS_PATH = "{$USUARIO_PATH}/{$ANEXOS_FOLDER}";

            // Crear directorios si no existen
            foreach ([$USUARIO_PATH, $ARCHIVO_PRINCIPAL_PATH, $ANEXOS_PATH] as $PATH) {
                if (!Storage::exists($PATH)) {
                    Storage::makeDirectory($PATH);
                }
            }

            $ARCHIVO_PRINCIPAL = $request->file('P_ARCHIVO_PRIN');
            $NOMBRE_ARCHIVOS_PRINCIPAL = $this->limpiarNombreArchivo($ARCHIVO_PRINCIPAL->getClientOriginalName());
            // $NOMBRE_ARCHIVOS_PRINCIPAL = $ARCHIVO_PRINCIPAL->getClientOriginalName();

            $RUTA_ARCHIVO_PRINCIPAL = Storage::putFileAs(
                $ARCHIVO_PRINCIPAL_PATH,
                $ARCHIVO_PRINCIPAL,
                $NOMBRE_ARCHIVOS_PRINCIPAL
            );
            $ARCHIVO_PRINCIPAL_DATA = [
                'nombre' => $NOMBRE_ARCHIVOS_PRINCIPAL,
                'ruta' => $RUTA_ARCHIVO_PRINCIPAL
            ];
            // dd($ARCHIVO_PRINCIPAL_DATA, $SOLICITUD_ID);
            $ANEXOS_DATA = [];
            if ($request->has('LIST_ANEXOS')) {
                foreach ($request->file('LIST_ANEXOS') as $anexo) {
                    // Verificar si el archivo existe y es válido
                    if (isset($anexo['P_ANEXOS']) && $anexo['P_ANEXOS'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $anexo['P_ANEXOS'];
                        $NOMBRE_ANEXO = $this->limpiarNombreArchivo($file->getClientOriginalName());
                        // $NOMBRE_ANEXO = $file->getClientOriginalName();
                        $RUTA_ANEXO = Storage::putFileAs(
                            $ANEXOS_PATH,
                            $file,
                            $NOMBRE_ANEXO
                        );
                        $ANEXOS_DATA[] = [
                            'nombre' => $NOMBRE_ANEXO,
                            'ruta' => $RUTA_ANEXO
                        ];
                    }
                }
            }
            // dd($ANEXOS_DATA,$ARCHIVO_PRINCIPAL_DATA);

            $mensaje = $this->cargarInformacioArchivos($ANEXOS_DATA, $ARCHIVO_PRINCIPAL_DATA, $SOLICITUD_ID);
            return $mensaje;
        } catch (\Exception $e) {
            return ['tipo' => 'error', 'mensaje' => 'Ocurrio un problema al guardar los archivos en el local, comunicate con el administrador' . $e->getMessage()];
            // return [ 'error','Ocurrio un problema al guardar los archivos en el local, comunicate con el administrador']; 
            //     'error' => $e->getMessage()
        }
    }
    private function cargarInformacioArchivos($ANEXOS_DATA = [], $ARCHIVO_PRINCIPAL_DATA, $SOLICITUD_ID)
    {
        try {
            // ARCHIVO PRINCIPAL
            $ARCHIVO_PRIN = new ArchivoPrincipal();
            $ARCHIVO_PRIN->SOLICITUD_ID = $SOLICITUD_ID;
            $ARCHIVO_PRIN->ARCHIPRIN_NOMBRE_FILE_ORIGEN = $ARCHIVO_PRINCIPAL_DATA['ruta'];
            $ARCHIVO_PRIN->CREATED_AT = now()->format('Y-m-d H:i:s');
            $ARCHIVO_PRIN->UPDATED_AT = now()->format('Y-m-d H:i:s');
            $ARCHIVO_PRIN->ARCHIPRIN_NOMBRE_FILE = $ARCHIVO_PRINCIPAL_DATA['nombre'];
            $ARCHIVO_PRIN->ARCHIPRIN_IS_UPLOAD = 0;
            $ARCHIVO_PRIN->save();

            // ANEXOS
            if (!empty($ANEXOS_DATA)) {
                foreach ($ANEXOS_DATA as $INDICE => $ITEM) {
                    $ANEXO = new Anexo();
                    $ANEXO->ANEX_NUMERO = $INDICE + 1;
                    $ANEXO->SOLICITUD_ID = $SOLICITUD_ID;
                    $ANEXO->ANEX_NOMBRE_FILE_ORIGEN = $ITEM['ruta'];
                    $ANEXO->ANEX_DETALLE = $ITEM['nombre'];
                    $ANEXO->ANEX_IS_UPLOAD = 0;
                    $ANEXO->ANEX_IND_HABILITADO = 1;
                    $ANEXO->CREATED_AT = now()->format('Y-m-d H:i:s');
                    $ANEXO->UPDATED_AT = now()->format('Y-m-d H:i:s');
                    $ANEXO->ANEX_NOMBRE_FILE = $ITEM['nombre'];

                    $ANEXO->save();
                }
            }

            // dd($ANEXOS_DATA);
            $mensaje = ['tipo' => 'success', 'mensaje' => 'Se registró la solicitud exitosamente'];
            // $mensaje = ['success', 'Se registro la solicitud exitosamente'];

            return $mensaje;
        } catch (\Throwable $th) {
            return ['tipo' => 'error', 'mensaje' => 'Ocurrio un error al guardar los archivos en BD, comunicate con el administrador'];
            // return [ 'error','Ocurrio un error al guardar los archivos en BD, comunicate con el administrador'];

        }
    }
    private function generarNombreUnico($nombreOriginal)
    {
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd_His');
        $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);

        return "{$nombreBase}_{$timestamp}_{$random}.{$extension}";
    }
    private function limpiarNombreArchivo($nombre)
    {
        $nombre = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $nombre);
        // Evitar nombres duplicados de archivo
        return strtolower($nombre);
    }
    public function filtrarSolicitud(Request $request)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'FILTRO_EXPEDIENTE' => 'nullable|string|max:255',
            'FILTRO_TIPO_EXPEDIENTE' => 'nullable|in:1,2,3',
            'FILTRO_ESTADO' => 'nullable|in:1,2,3,4',
            'FILTRO_FECHA_INICIO' => 'nullable|date',
            'FILTRO_FECHA_FIN' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // 2. Preparar los parámetros base
            $params = [];
            $queryParts = [];

            // Documento de usuario (obligatorio)
            $NUMERO_DOCUMENTO_PERSONA = session('user')->USU_NUMERO_DOCUMENTO;
            $queryParts[] = "@NUMERO_DOCUMENTO_PERSONA = N'" . $NUMERO_DOCUMENTO_PERSONA . "'";

            // Número de expediente
            if ($request->FILTRO_EXPEDIENTE && $request->FILTRO_EXPEDIENTE != '0') {
                $queryParts[] = "@P_NU_EMI = N'" . $request->FILTRO_EXPEDIENTE . "'";
            }

            // Tipo de expediente
            if ($request->FILTRO_TIPO_EXPEDIENTE && $request->FILTRO_TIPO_EXPEDIENTE != '0') {
                $queryParts[] = "@P_TIPO_EXPEDIENTE = " . $request->FILTRO_TIPO_EXPEDIENTE;
            }

            // Estado
            if ($request->FILTRO_ESTADO && $request->FILTRO_ESTADO != '0') {
                $queryParts[] = "@P_ESTADO = " . $request->FILTRO_ESTADO;
            }

            // Fecha inicio
            if ($request->FILTRO_FECHA_INICIO) {
                $queryParts[] = "@P_DESDE = '" . $request->FILTRO_FECHA_INICIO . "'";
            }

            // Fecha fin (con valor por defecto si no se proporciona)
            $fechaFin = $request->FILTRO_FECHA_FIN ?: now()->format('Y-m-d');
            $queryParts[] = "@P_HASTA = '" . $fechaFin . "'";

            // 3. Construir la consulta final
            $query = "EXEC [MDSJL].[FILTRAR_SOLICITUD] " . implode(", ", $queryParts);

            // 4. Ejecutar la consulta
            $RESULTADO = DB::select($query);

            // 5. Retornar resultado como JSON
            return response()->json([
                'status' => 'success',
                'data' => $RESULTADO
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la solicitud'
            ], 500);
        }
    }

}