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


Route::prefix('backend')->middleware(['auth', 'checkrole:1,2,3,5'])->group(function () {

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

    Route::put('/usuarios/{user}/aprobar', [UserController::class, 'aprobar'])->name('usuarios.aprobar');

    Route::put('/usuarios/{user}/rol', [UserController::class, 'cambiarRol'])->name('usuarios.rol');

});


require __DIR__.'/auth.php';

require __DIR__.'/roles.php';

require __DIR__.'/back-home.php';

require __DIR__.'/provincia.php';

require __DIR__.'/localidad.php';

require __DIR__.'/zona-barrio.php';

require __DIR__.'/barrio.php';

require __DIR__.'/enfermedad.php';

require __DIR__.'/estado-civil.php';

require __DIR__.'/niveles-estudio.php';

require __DIR__.'/beneficio.php';

require __DIR__.'/programa-asistencia.php';

require __DIR__.'/categoria-ocupacional.php';

require __DIR__.'/cobertura.php';

require __DIR__.'/condiciones-inactividad.php';

require __DIR__.'/discapacidad.php';
require __DIR__.'/trabajo.php';



require __DIR__.'/home.php';

require __DIR__.'/persona.php';

require __DIR__.'/grupoFamiliar.php';

require __DIR__.'/atenciones.php';


//rutas para recepcion
require __DIR__.'/recepcion.php';
require __DIR__.'/mercaderia.php';