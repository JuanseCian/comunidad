<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\AtencionController;
use App\Models\Atencion;
use App\Models\Persona;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.access');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rutas para aceptar usuarios
Route::prefix('backend')->middleware(['auth'])->group(function () {

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

    Route::put('/usuarios/{user}/aprobar', [UserController::class, 'aprobar'])->name('usuarios.aprobar');

    Route::put('/usuarios/{user}/rol', [UserController::class, 'cambiarRol'])->name('usuarios.rol');

});

//RUTAS DEL BACKEND
require __DIR__.'/auth.php';
//rutas para los roles
require __DIR__.'/roles.php';
//rutas para BackHome
require __DIR__.'/back-home.php';
//rutas para provincias
require __DIR__.'/provincia.php';
//rutas para localidades
require __DIR__.'/localidad.php';
//rutas para zonas y barrios
require __DIR__.'/zona-barrio.php';
//rutas para barrios
require __DIR__.'/barrio.php';
//rutas para enfermedades
require __DIR__.'/enfermedad.php';
//rutas para estados civiles
require __DIR__.'/estado-civil.php';
//rutas para niveles de estudio
require __DIR__.'/niveles-estudio.php';
//rutas para beneficios
require __DIR__.'/beneficio.php';
//rutas para programas de asistencia
require __DIR__.'/programa-asistencia.php';
//rutas para categorias ocupacionales
require __DIR__.'/categoria-ocupacional.php';
//rutas para coberturas
require __DIR__.'/cobertura.php';
//rutas para condiciones de inactividad
require __DIR__.'/condiciones-inactividad.php';
//rutas para discapacidades
require __DIR__.'/discapacidad.php';


//RUTAS DEL FRONTEND
//rutas para el home
require __DIR__.'/home.php';
//rutas para personas
require __DIR__.'/persona.php';
//rutas para grupos familiares
require __DIR__.'/grupoFamiliar.php';
//rutas para atenciones
require __DIR__.'/atenciones.php';
