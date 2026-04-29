<?php

use App\Http\Controllers\frontend\GrupoFamiliarController;
use App\Http\Controllers\frontend\PersonaController;

Route::prefix('personas/{persona}/grupo-familiar')
    ->name('personas.grupo-familiar.')
    ->middleware('auth')
    ->group(function () {

        // GET  /personas/{persona}/grupo-familiar/create
        Route::get('create', [GrupoFamiliarController::class, 'create'])->name('create');

        // POST /personas/{persona}/grupo-familiar
        Route::post('/', [GrupoFamiliarController::class, 'store'])->name('store');
    });

// Código de grupo familiar (familias)
Route::middleware('auth')->group(function () {
    Route::patch('/personas/{id}/familia/vincular',    [PersonaController::class, 'vincularFamilia'])   ->name('personas.familia.vincular');
    Route::patch('/personas/{id}/familia/desvincular', [PersonaController::class, 'desvincularFamilia'])->name('personas.familia.desvincular');
});