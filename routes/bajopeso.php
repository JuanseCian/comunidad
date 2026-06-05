<?php
use App\Http\Controllers\frontend\BajoPesoController;
use App\Http\Controllers\frontend\BajoPesoEntregaController;

Route::prefix('recepcion')
    ->name('recepcion.')
    ->group(function () {
        
        // Búsqueda de menores para autocomplete
        Route::get(
            'bajo-peso/buscar-personas',
            [BajoPesoController::class, 'buscarMenores']
        )->name('bajo-peso.buscar-personas');

    });

Route::resource(
    'bajo-peso',
    BajoPesoController::class
);

Route::get(
    'bajo-peso/persona/{id}',
    [BajoPesoController::class, 'datosPersona']
)->name('bajo-peso.persona');

Route::post(
    'bajo-peso/{id}/entrega',
    [BajoPesoEntregaController::class, 'store']
)->name('recepcion.bajo-peso.entrega.store');

Route::delete(
    'bajo-peso-entrega/{id}',
    [BajoPesoEntregaController::class, 'destroy']
)->name('recepcion.bajo-peso.entrega.destroy');