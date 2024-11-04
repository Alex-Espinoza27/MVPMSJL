<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Sgd\Models\Ubicacion;


class SeguridadController extends Controller
{
    public function index(){
        return view('seguridad.login');
    }
    public function registrar(){
        $departamentos = Ubicacion::where('STUBI', '1')
                        ->select('UBDEP', 'NODEP')->distinct()->get();
                        
        return view('seguridad.registrar', compact('departamentos'));
    }

}
