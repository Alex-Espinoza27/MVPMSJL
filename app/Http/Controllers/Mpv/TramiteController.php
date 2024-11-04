<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mpv\Modals\TipoDocumento;
use App\Http\Controllers\Sgd\Models\Tupa;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    public function solicitud(){
        // dd("entro");
        $page_data['header_js'] = array(
            // select2 
            'js/js_solicitud.js',
            //table
            'plugins/datatables/jquery.dataTables.min.js',
            'plugins/datatables/dataTables.bootstrap5.min.js',
            'pages/jquery.datatable.init.js',

            'plugins/datatables/dataTables.buttons.min.js',
            'plugins/datatables/buttons.bootstrap5.min.js',
            // repetir anexos
            'plugins/repeater/jquery.repeater.min.js',
            'pages/jquery.form-repeater.js',
            // cargar archivos
            'plugins/dropify/js/dropify.min.js',
            'pages/jquery.form-upload.init.js'
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

        return view('index',$page_data);
    }
    public function tupa(){
        // dd('entro');
        // dd(Tupa::all());

        $tupa = Tupa::all(); 
        return response()->json($tupa);
    }
    
    public function tipoDocumento(){
        $tipoDocumento = TipoDocumento::all();
        dd($tipoDocumento);
        return response()->json($tipoDocumento);
    }
} 