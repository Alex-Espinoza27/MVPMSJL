<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\Mpv\AdmintrarSolicitud;
use App\Http\Controllers\Mpv\ObservadoController;
use App\Http\Controllers\Mpv\TramiteController;
use App\Http\Controllers\Sgd\UbigeoController;
use App\Http\Controllers\Usuario\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seguridad\SeguridadController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', action: [SeguridadController::class, 'index'])->name('seguridad.login');
Route::get('/registrar', [SeguridadController::class, 'registrar'])->name('seguridad.registrar');

// Route::get('/usuario', [SeguridadController::class, 'usuario']);

Route::post('iniciar-sesion', [UsuarioController::class, 'login'])->name('login.submit');
Route::post('registrar-usuario', [UsuarioController::class, 'store'])->name('login.registrar');

Route::get('/departamentos', [UbigeoController::class,'departamentos'])->name('departamento');
Route::get('/provincias/{departamento}', [UbigeoController::class,'provincias'])->name('departamento.provincias');
Route::get('/distritos/{departamento}/{provincia}', action: [UbigeoController::class,'distritos'])->name('getDistritos');



Route::middleware(['session.check'])->group(function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    Route::prefix('usuario')->group(function () {
        // perfil / modificar
        Route::get('/perfil', [UsuarioController::class, 'perfilIndex'])->name('perfil');
        Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');
        Route::post('/cambiarClave', [UsuarioController::class, 'cambiarClave'])->name('cambiarClave');

        Route::get('/usuarioRepresentante', [UsuarioController::class, 'usuarioRepresentante'])->name('usuario');
        Route::post('/actualizarUsuario', [UsuarioController::class, 'actualizarPerfil'])->name('actualizarUsuario');
    });

    Route::prefix('tramite')->group(function () {
        Route::get('/solicitud', [TramiteController::class, 'solicitudIndex'])->name('solicitud');
        Route::get('/solicitud/lista', [TramiteController::class,'listarSolicitud'])->name('solicitud.lista');
        Route::get('/solicitud/tramitadorLista', [TramiteController::class,'listarSolicitudComoTramitador'])->name('solicitud.lista.tramitador');
        Route::post('/solicitud/filtro', [TramiteController::class,'filtrarSolicitud'])->name('solicitud.filtro');

        Route::get('/solicitud/tupa', [TramiteController::class, 'tupa'])->name('solicitud.tupa');
        Route::get('/solicitud/tipoDocumento', [TramiteController::class, 'tipoDocumento'])->name('solicitud.tipoDocumento');
        Route::get('/solicitud/estadoDocumento', [TramiteController::class, 'estadoDocumento'])->name('solicitud.estadoDocumento');
        Route::post('/solicitud/registrar', [TramiteController::class,'registrarSolicitud'])->name('tramite.solicitud.registrar');
        
        Route::get('/solicitud/{solicitudID}', [TramiteController::class, 'solictudID'])->name('solicitud.solicitudID');
    });
    
    Route::prefix('observado')->group(function () {
        Route::get('/observado', [ObservadoController::class, 'observadosIndex'])->name('docObservados');
        Route::get('/lista', [ObservadoController::class, 'listarObservados'])->name('oservados.lista');
    });

    Route::prefix('administrarSolicitud')->group(function () {
        Route::get('/administrar', [AdmintrarSolicitud::class, 'administrarIndex'])->name('administrar.solicitud');    
        Route::post('/registrarObservacion', [AdmintrarSolicitud::class, 'registrarObservacion'])->name('administrar.registrar.Observacion');    

    }); 

});


