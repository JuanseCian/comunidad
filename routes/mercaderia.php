<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\MercaderiaController;

Route::prefix('recepcion')
    ->middleware(['auth', 'checkrole:6'])
    ->name('recepcion.')
    ->group(function () {

        // Búsqueda de personas para autocomplete de mercaderías
        Route::get(
            '/mercaderias/buscar-personas',
            [MercaderiaController::class, 'buscarPersonas']
        )->name('mercaderias.buscar-personas');

        Route::resource('mercaderias', MercaderiaController::class);

    });

Route::prefix('panel')
    ->middleware(['auth', 'checkrole:2,3']) // Admin y Coordinador
    ->name('panel.')
    ->group(function () {

        Route::get(
            '/mercaderias',
            [MercaderiaController::class, 'readonlyIndex']
        )->name('mercaderias.index');

    });

Route::get(
    '/mercaderias/imprimir',
    [MercaderiaController::class, 'imprimir']
)->name('recepcion.mercaderias.imprimir');
