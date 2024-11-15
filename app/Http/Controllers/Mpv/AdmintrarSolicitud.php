<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mpv\Models\HistorialSolicitud;
use App\Http\Controllers\Mpv\Models\Solicitud;
use Illuminate\Http\Request;

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

    public function registrarObservacion(Request $request){
        dd($request->all());

        $validatedData = $request->validate([
            'P_MENSAJE_OBSERVACION' => 'required|string|min:15|max:200',
            'P_FECHA_LIMITE_SUBSANACION' => 'required|date|after:today', // Fecha debe ser posterior a hoy
            'P_ARCHIVO_OBSERVACION' => 'nullable|file|mimes:pdf,png,jpeg,doc,docx|max:20480', // Máximo 20 MB
        ]);
        if ($validatedData->fails()) {
            return ['tipo' => 'error', 'mensaje' => 'Los datos no cumplen con las restricciones' ];
        }

        
        $HISTORIAL = new HistorialSolicitud();
        $SOLICITUD = Solicitud::where('SOLI_ID',$request->input('ID_SOLICITUD') );

        $HISTORIAL->HIS_NUMERO = maxNumeroHistorial($request->input('ID_SOLICITUD')); // nvarchar(191)   NULL,
        $HISTORIAL->HIS_NU_ANN = now()->format('Y'); // nvarchar(10)   NULL,
        $HISTORIAL->SOLICITUD_ID = $request->input('ID_SOLICITUD'); // bigint NOT NULL,
        // $HISTORIAL->HIS_ASUNTO = 
        $HISTORIAL->CREATED_AT = now()->format('Y-m-d'); // datetime2(0) NULL,
        $HISTORIAL->CREATED_BY = session('user')->USU_ID;// int NULL,
        $HISTORIAL->SOLI_OBSERVADO_BY = session('user')->USU_NUMERO_DOCUMENTO; // nvarchar(30)   NOT NULL,
        $HISTORIAL->HIS_ESTADO = '3';// int NOT NULL,
        $HISTORIAL->HIS_FECHA_OBSERVACION = now()->format('Y-m-d');  // datetime2(0) NULL,
        
        $HISTORIAL->HIS_OBSERVACION = $request->input('P_MENSAJE_OBSERVACION');// nvarchar   NULL,
        $HISTORIAL->HIS_FECHA_OBSERVACION = now()->format('Y-m-d'); 
        if($request->input('P_FECHA_LIMITE_SUBSANACION')){
            $HISTORIAL->HIS_FECHA_LIMITE_SUBSANACION = $request->input('P_FECHA_LIMITE_SUBSANACION');
            $SOLICITUD->SOLI_FECHA_LIMITE_SUBSANACION = $request->input('P_FECHA_LIMITE_SUBSANACION');
        }


        if($request->file('P_ARCHIVO_OBSERVACION')){
            $HISTORIAL->HIS_FECHA_LIMITE_SUBSANACION = $request->file('P_FECHA_LIMITE_SUBSANACION');
            $model = new  TramiteController();
            $ruta = $model->guardarArchivosPlantilla($request->file('P_FECHA_LIMITE_SUBSANACION'),$SOLICITUD->CREATED_BY,$request->input('ID_SOLICITUD'), 'observacion' );
            $HISTORIAL->HIS_FILE_OBSERVACION = ($ruta == 'error')? '': $ruta;
            $SOLICITUD->SOLI_FILE_OBSERVACION = ($ruta == 'error')? '': $ruta;
        }

        
        $SOLICITUD->SOLI_FECHA_OBSERVACION =  now()->format('Y-m-d');;
        $SOLICITUD->SOLI_OBSERVACION  = $request->input('P_MENSAJE_OBSERVACION');
        $SOLICITUD->SOLI_OBSERVADO_BY  = session('user')->USU_NUMERO_DOCUMENTO; 
        $SOLICITUD->SOLI_ESTADO_ID  = '3';

        try {
            $HISTORIAL->save();
            $SOLICITUD->save();
            // return response()->json(['success', 'Se registro exitosamente la observacion']);
            return response()->json([
                'tipo' => 'success',
                'mensaje' => 'Se registro exitosamente la observacion'
            ]);

        } catch (\Throwable $th) {
            // return response()->json(['error', 'Ocurrio un problema intentalo otra vez']);
            return response()->json([
                'tipo' => 'error',
                'mensaje' => 'Ocurrio un problema intentalo otra vez'
            ]);

        }

        
    }
    public function maxNumeroHistorial($solicitud_ID){
        $MAX = HistorialSolicitud::where('SOLICITUD_ID',$solicitud_ID)
        ->max('HIS_NUMERO')->first();

        return $MAX ? $MAX : 1;
    }
    public function guardarArchivo($archivo, $solicitud_ID){

    }
}
