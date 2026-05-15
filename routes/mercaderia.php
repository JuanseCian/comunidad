<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\frontend\MercaderiaController;

Route::prefix('recepcion')

    ->middleware([
        'auth',
        'checkrole:6'
    ])

    ->name('recepcion.')

    ->group(function () {

        Route::get(
            '/mercaderias/buscar-personas',
            [MercaderiaController::class, 'buscarPersonas']
        )->name(
            'mercaderias.buscar-personas'
        );

        Route::resource(
            'mercaderias',
            MercaderiaController::class
        );

    });