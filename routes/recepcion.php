<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\IngresoController;

Route::prefix('recepcion')
    ->middleware(['auth', 'checkrole:6'])
    ->name('recepcion.')
    ->group(function () {

        Route::get('/', function () {
            return view('frontend.recepcion.dashboard');
        })->name('dashboard');

        // Búsqueda de personas para autocomplete de ingresos
        Route::get(
            '/ingresos/buscar-personas',
            [IngresoController::class, 'buscarPersonas']
        )->name('ingresos.buscar-personas');

        Route::resource('ingresos', IngresoController::class);

    });
