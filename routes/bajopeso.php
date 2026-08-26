<?php

use App\Http\Controllers\frontend\BajoPesoController;
use App\Http\Controllers\frontend\BajoPesoEntregaController;

Route::prefix('recepcion')
    ->middleware(['auth', 'checkrole:6'])
    ->name('recepcion.')
    ->group(function () {
        // Búsqueda de personas para autocomplete
        Route::get(
            'bajo-peso/buscar-personas',
            [BajoPesoController::class, 'buscarMenores']
        )->name('bajo-peso.buscar-personas');

        Route::get(
            'bajo-peso/persona/{id}',
            [BajoPesoController::class, 'datosPersona']
        )->name('bajo-peso.persona');

        Route::post(
            'bajo-peso/{id}/entrega',
            [BajoPesoEntregaController::class, 'store']
        )->name('bajo-peso.entrega.store');

        Route::delete(
            'bajo-peso-entrega/{id}',
            [BajoPesoEntregaController::class, 'destroy']
        )->name('bajo-peso.entrega.destroy');

        Route::resource('bajo-peso', BajoPesoController::class);
    });
