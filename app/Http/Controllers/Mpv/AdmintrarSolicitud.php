<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mpv\Models\HistorialSolicitud;
use App\Http\Controllers\Mpv\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AdmintrarSolicitud extends Controller
{

 
    public function administrarIndex(){
        // dd("entro");
        $page_data['header_js'] = array(
            // 'js/js_solicitud.js',
            'js/js_adminSolicitud.js',

            //table
            'plugins/datatables/jquery.dataTables.min.js',
            'plugins/datatables/dataTables.bootstrap5.min.js',
            'pages/jquery.datatable.init.js',
            // repetir anexos
            // 'plugins/repeater/jquery.repeater.min.js',
            // 'pages/jquery.form-repeater.js',
            // cargar archivos
            // 'plugins/dropify/js/dropify.min.js',
            // 'pages/jquery.form-upload.init.js',
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
            // 'plugins/dropify/css/dropify.min.css',
            // 'plugins/datatables/responsive.bootstrap4.min.css',
        );
        $page_data['page_directory'] = 'tramite'; // carpeta
        $page_data['page_name'] = 'administrarSolicitud'; // nombre carpeta
        $page_data['page_title'] = 'Administrar Solicitud';
        $page_data['breadcrumb'] = 'Administrar Solicitud';

        // dd($SOLICITUDES);
        return view('index', $page_data, );
    }

    // Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException: The GET method is not supported 
    // for route administrarSolicitud/registrarObservacion. Supported methods: POST. in file
    // C:\laragon\www\MPVSJL\vendor\laravel\framework\src\Illuminate\Routing\AbstractRouteCollection.php on line 122

    public function registrarObservacion(Request $request){

        $validator = Validator::make($request->all(), [
            'P_MENSAJE_OBSERVACION' => 'required|string|min:15|max:200',
            'P_FECHA_LIMITE_SUBSANACION' => 'nullable|date|after:today',
            'P_ARCHIVO_OBSERVACION' => 'nullable|file|mimes:pdf,png,jpeg,doc,docx|max:20480', // Máximo 20 MB
            'ID_SOLICITUD' => 'required|integer',
            'TIPO_REGISTRO_OBSERVACION' => 'required|integer',
        ]);


        dd("paso", $request);
        if ($validator->fails()) {
            return response()->json([
                'tipo' => 'error',
                'mensaje' => $validator->errors()->first()
                // 'mensaje' => 'Los datos no cumplen con las restricciones'
            ]);
        }

    
        $HISTORIAL = new HistorialSolicitud();
        $SOLICITUD = Solicitud::where('SOLI_ID',$request->input('ID_SOLICITUD'))->first();

        $HISTORIAL->HIS_NUMERO = $this->maxNumeroHistorial($request->input('ID_SOLICITUD'));
        $HISTORIAL->HIS_NU_ANN = now()->format('Y'); 
        $HISTORIAL->SOLICITUD_ID = $request->input('ID_SOLICITUD');

        $HISTORIAL->CREATED_AT = now()->format('Y-m-d');
        $HISTORIAL->CREATED_BY = session('user')->USU_ID;
        $HISTORIAL->SOLI_OBSERVADO_BY = session('user')->USU_NUMERO_DOCUMENTO; 
        $HISTORIAL->HIS_ESTADO = '3';   
        $HISTORIAL->HIS_FECHA_OBSERVACION = now()->format('Y-m-d');
        
        $HISTORIAL->HIS_OBSERVACION = $request->input('P_MENSAJE_OBSERVACION');
        $HISTORIAL->HIS_FECHA_OBSERVACION = now()->format('Y-m-d'); 
        if($request->input('P_FECHA_LIMITE_SUBSANACION')){
            $HISTORIAL->HIS_FECHA_LIMITE_SUBSANACION = $request->input('P_FECHA_LIMITE_SUBSANACION');
            $SOLICITUD->SOLI_FECHA_LIMITE_SUBSANACION = $request->input('P_FECHA_LIMITE_SUBSANACION');
        }

        // dd($SOLICITUD);
        if($request->file('P_ARCHIVO_OBSERVACION')){
            $model = new  TramiteController();
            $ruta = $model->guardarArchivosPlantilla($request->file('P_ARCHIVO_OBSERVACION'),$SOLICITUD->CREATED_BY,$request->input('ID_SOLICITUD'), 'observacion' );
            $HISTORIAL->HIS_FILE_OBSERVACION = ($ruta == 'error')? '': $ruta;
            $SOLICITUD->SOLI_FILE_OBSERVACION = ($ruta == 'error')? '': $ruta;
        }

        
        $SOLICITUD->SOLI_FECHA_OBSERVACION =  now()->format('Y-m-d');
        $SOLICITUD->SOLI_OBSERVACION  = $request->input('P_MENSAJE_OBSERVACION');
        // $SOLICITUD->SOLI_OBSERVACION  = 'Prueba de como hacer la reunion';
        $SOLICITUD->SOLI_OBSERVADO_BY  = session('user')->USU_NUMERO_DOCUMENTO; 
        $SOLICITUD->SOLI_ESTADO_ID  = 3; //estado observado

        // dd($HISTORIAL,$SOLICITUD);
        try {
            $HISTORIAL->save();
            $SOLICITUD->save();
            return response()->json(['success', 'Se registro exitosamente la observacion']);
            // return response()->json([ 'success' => 'success', 'mensaje' => 'Se registro exitosamente la observacion']);

        } catch (\Throwable $th) {
            return response()->json(['error', 'Ocurrio un problema intentalo otra vez']);
            // return response()->json([ 'tipo' => 'error', 'mensaje' => 'Ocurrio un problema intentalo otra vez'.$th->getMessage()]);
        }
    }
    public function maxNumeroHistorial($solicitud_ID){
        $MAX = HistorialSolicitud::where('SOLICITUD_ID',$solicitud_ID)
        ->max('HIS_NUMERO');

        return $MAX ? $MAX : 1;
    }
    public function guardarArchivo($archivo, $solicitud_ID){

    }
}
