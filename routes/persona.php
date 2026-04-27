<?php
use App\Http\Controllers\frontend\PersonaController;
use App\Http\Controllers\frontend\PersonaProgramaController;

Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
Route::get('/personas/{id}', [PersonaController::class, 'show'])
    ->name('personas.show');
Route::get('/personas/{id}/edit', [PersonaController::class, 'edit'])
    ->name('personas.edit');
Route::put('/personas/{id}', [PersonaController::class, 'update'])
    ->name('personas.update');
Route::get('/personas', [PersonaController::class, 'index'])
    ->name('personas.index');

Route::put('/personas/{id}/datos', [PersonaController::class, 'updateDatos'])
    ->name('personas.updateDatos');

Route::put('/personas/{id}/domicilio', [PersonaController::class, 'updateDomicilio'])
    ->name('personas.updateDomicilio');

// Rutas para asignar programas a personas
Route::post('/persona-programa', [PersonaProgramaController::class, 'store'])
    ->name('persona-programa.store');
    
Route::put('/persona-programa/{id}', [PersonaProgramaController::class, 'update'])
    ->name('persona-programa.update');


Route::post('/personas/{id}/cambiar-programa', [PersonaController::class, 'cambiarPrograma'])
    ->name('personas.cambiarPrograma');