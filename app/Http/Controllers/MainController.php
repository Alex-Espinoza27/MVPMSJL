<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class MainController extends Controller
{
    public function dashboard(){
        #dd(Session::get('user'));

        $page_data['header_js'] = array(
            'js/js_main.js'
        );
        
        $page_data['header_css'] = array();
        $page_data['page_directory'] = 'main'; // carpeta
        $page_data['page_name'] = 'dashboard'; // nombre carpeta
        $page_data['page_title'] = 'Main Portal';
        $page_data['breadcrumb'] = 'dashboard';
        return view('index',$page_data);
    }
}
