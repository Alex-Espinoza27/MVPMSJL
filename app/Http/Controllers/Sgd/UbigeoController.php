<?php

namespace App\Http\Controllers\Sgd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Seguridad\Models\Usuario;
use App\Http\Controllers\Sgd\Models\Ubicacion;

class UbigeoController extends Controller
{
    public function departamentos(){
        $Departamentos = Ubicacion::Where("STUBI",'1') 
        ->whereNotIn('UBDEP', ['91','92','93','94','95'])
        ->select('UBDEP','NODEP')
        ->groupBy('UBDEP','NODEP')->get();
        // dd($Departamentos);
        return response()->json($Departamentos);
    }
    public function provincias($deparmento){

        $pronvincias = Ubicacion::Where("UBDEP",$deparmento)
        ->whereNot("UBPRV",'00')
        ->whereNot("NOPRV",'00')
        ->select('UBDEP','UBPRV','NOPRV')
        ->groupBy('UBDEP','UBPRV','NOPRV' )->get();
        return response()->json($pronvincias);
    }
    public function distritos($departamento,$provincia){
        $distritos = Ubicacion::Where("UBDEP",$departamento)
        ->Where("UBPRV",$provincia)
        ->whereNot("UBDIS",'00')
        ->select('UBDEP','UBPRV','UBDIS','NODIS')
        ->groupBy('UBDEP','UBPRV','UBDIS','NODIS')
        ->get();
        return response()->json($distritos);
    }
}

 