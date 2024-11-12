<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObservadoController extends Controller
{
    
    public function observados()
    { 
        $page_data['header_js'] = array(
            // select2 
            'js/js_general.js',
            // 'js/js_solicitud.js',
            'js/js_observado.js',
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

}
