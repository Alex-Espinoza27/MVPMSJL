<?php

use App\Http\Controllers\MainController;
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
Route::get('/', [SeguridadController::class, 'index'])->name('seguridad.login');
Route::get('/registrar', [SeguridadController::class, 'registrar'])->name('seguridad.registrar');

Route::get('/usuario', [SeguridadController::class, 'usuario']);


Route::get('/provincias/{departamento}', [UbigeoController::class,'provincias'])->name('getProvincias');
Route::get('/distritos/{departamento}/{provincia}', action: [UbigeoController::class,'distritos'])->name('getDistritos');

Route::post('iniciar-sesion', [UsuarioController::class, 'login'])->name('login.submit');

Route::middleware(['session.check'])->group(function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    

    Route::prefix('usuario')->group(function () {
        // perfil / modificar
        Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');
    });
    Route::prefix('tramite')->group(function () {
        Route::get('/solicitud', [TramiteController::class, 'solicitud'])->name('solicitud');
        Route::get('/solicitud/tupa', [TramiteController::class, 'tupa'])->name('solicitud.tupa');

    });


});
