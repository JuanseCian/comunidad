<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;
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
    return view('auth.access'); // 👈 este cambio es clave
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');

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


//RUTAS DEL FRONTEND
//rutas para el home
require __DIR__.'/home.php';
