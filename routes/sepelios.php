<?php

Route::prefix('recepcion/sepelios')
    ->name('recepcion.sepelios.')
    ->group(function () {

        Route::get('/', [
            \App\Http\Controllers\Frontend\SepelioController::class,
            'index'
        ])->name('index');

        Route::get('/create', [
            \App\Http\Controllers\Frontend\SepelioController::class,
            'create'
        ])->name('create');

        Route::post('/', [
            \App\Http\Controllers\Frontend\SepelioController::class,
            'store'
        ])->name('store');

        Route::get('/buscar-personas', [
            \App\Http\Controllers\Frontend\SepelioController::class,
            'buscarPersonas'
        ])->name('buscar-personas');

        Route::get('/{sepelio}', [
            \App\Http\Controllers\Frontend\SepelioController::class,
            'show'
        ])->name('show');

        Route::delete('/{sepelio}', [
            \App\Http\Controllers\Frontend\SepelioController::class,
            'destroy'
        ])->name('destroy');
    });