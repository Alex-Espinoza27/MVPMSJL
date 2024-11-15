<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mpv\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObservadoController extends Controller
{
    
    public function observadosIndex()
    { 
        $page_data['header_js'] = array(
            // select2 
            'js/js_general.js',
            // 'js/js_solicitud.js',
            'js/js_observado.js',

            // form validation 
            // 'pages/jquery.validation.init.js',
            'plugins/parsleyjs/parsley.min.js',

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
            
            //tablas
            'plugins/datatables/dataTables.buttons.min.js',
            'plugins/datatables/buttons.bootstrap5.min.js',

        );

        $page_data['header_css'] = array(
            'plugins/datatables/dataTables.bootstrap5.min.css',
            'plugins/datatables/buttons.bootstrap5.min.css',
            'plugins/dropify/css/dropify.min.css', 
            'plugins/datatables/responsive.bootstrap4.min.css',
        );
        $page_data['page_directory'] = 'tramite'; // carpeta
        $page_data['page_name'] = 'observado'; // nombre carpeta
        $page_data['page_title'] = 'Documentos Observados';
        $page_data['breadcrumb'] = 'Observados';

        // dd($SOLICITUDES);
        return view('index', $page_data, );
    }
    public function listarObservados(){
        try {
            $USUARIO = session('user')->USU_NUMERO_DOCUMENTO;
            $observados = DB::select('EXEC [MDSJL].[FILTRAR_SOLICITUD] @NUMERO_DOCUMENTO_PERSONA = ?, @P_ESTADO = ?', [$USUARIO,3]);
            return response()->json($observados);
        } catch (\Throwable $th) {
            return response()->json('Ocurrio un problema en la base de datos' . $th->getMessage());
        }
    }

}
