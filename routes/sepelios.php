<?php

use App\Http\Controllers\frontend\SepelioController;

Route::prefix('recepcion/sepelios')
    ->name('recepcion.sepelios.')
    ->group(function () {

        Route::get('/', [SepelioController::class, 'index'])
            ->name('index');

        Route::get('/create', [SepelioController::class, 'create'])
            ->name('create');

        Route::post('/', [SepelioController::class, 'store'])
            ->name('store');

        Route::get('/buscar-personas', [SepelioController::class, 'buscarPersonas'])
            ->name('buscar-personas');

        Route::get('/{sepelio}', [SepelioController::class, 'show'])
            ->name('show');

        Route::delete('/{sepelio}', [SepelioController::class, 'destroy'])
            ->name('destroy');
    });
