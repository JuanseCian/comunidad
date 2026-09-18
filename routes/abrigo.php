<?php

use App\Http\Controllers\frontend\EntregaAbrigoController;
use Illuminate\Support\Facades\Route;

Route::prefix('recepcion')
    ->middleware(['auth', 'checkrole:6'])
    ->name('recepcion.')
    ->group(function () {
        Route::get('abrigo/buscar-personas', [EntregaAbrigoController::class, 'buscarPersonas'])
            ->name('abrigo.buscar-personas');
        Route::get('abrigo/imprimir', [EntregaAbrigoController::class, 'imprimir'])
            ->name('abrigo.imprimir');
        Route::resource('abrigo', EntregaAbrigoController::class)->except(['destroy']);
    });

Route::prefix('estadisticas/abrigo')
    ->middleware(['auth', 'checkrole:6'])
    ->name('estadisticas.abrigo.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\frontend\Estadisticas\EntregaAbrigoEstadisticaController::class, 'index'])
            ->name('index');
        Route::get('/excel', [\App\Http\Controllers\frontend\Estadisticas\EntregaAbrigoEstadisticaController::class, 'exportExcel'])
            ->name('excel');
    });
