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

// Rutas para asignar programas a personas
Route::post('/persona-programa', [PersonaProgramaController::class, 'store'])
    ->name('persona-programa.store');
    
    