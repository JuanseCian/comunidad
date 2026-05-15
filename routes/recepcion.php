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

        Route::get(
            '/buscar-personas',
            [IngresoController::class, 'buscarPersonas']
        )->name('personas.buscar');

        Route::resource('ingresos', IngresoController::class);
    });