<?php
use App\Http\Controllers\PersonaController;

Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
Route::get('/personas/{id}', [PersonaController::class, 'show'])
    ->name('personas.show');
Route::get('/personas', [PersonaController::class, 'index'])
    ->name('personas.index');