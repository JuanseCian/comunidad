<?php


use App\Http\Controllers\GrupoFamiliarController;

Route::prefix('personas/{persona}/grupo-familiar')
    ->name('personas.grupo-familiar.')
    ->middleware('auth')
    ->group(function () {

        // GET  /personas/{persona}/grupo-familiar/create
        Route::get('create', [GrupoFamiliarController::class, 'create'])->name('create');

        // POST /personas/{persona}/grupo-familiar
        Route::post('/', [GrupoFamiliarController::class, 'store'])->name('store');

    });