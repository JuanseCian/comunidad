<?php

use App\Http\Controllers\frontend\GrupoFamiliarController;
use App\Http\Controllers\frontend\PersonaController;

Route::prefix('personas/{persona}/grupo-familiar')
    ->name('personas.grupo-familiar.')
    ->middleware('auth')
    ->group(function () {

       
        Route::get('create', [GrupoFamiliarController::class, 'create'])->name('create');

       
        Route::post('/', [GrupoFamiliarController::class, 'store'])->name('store');
        Route::get('/grupo-familiar/{grupoFamiliar}/edit', [GrupoFamiliarController::class, 'edit'])->name('grupo-familiar.edit');
        Route::put('/grupo-familiar/{grupoFamiliar}', [GrupoFamiliarController::class, 'update'])->name('grupo-familiar.update');
    });


Route::middleware('auth')->group(function () {
    Route::patch('/personas/{id}/familia/vincular',    [PersonaController::class, 'vincularFamilia'])   ->name('personas.familia.vincular');
    Route::patch('/personas/{id}/familia/desvincular', [PersonaController::class, 'desvincularFamilia'])->name('personas.familia.desvincular');
});