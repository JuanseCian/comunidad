<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\Estadisticas\DashboardController;
use App\Http\Controllers\Frontend\Estadisticas\IngresoEstadisticaController;
use App\Http\Controllers\Frontend\Estadisticas\DestinatarioEstadisticaController;
use App\Http\Controllers\Frontend\Estadisticas\BeneficioEstadisticaController;
use App\Http\Controllers\Frontend\Estadisticas\AtencionEstadisticaController;
use App\Http\Controllers\Frontend\Estadisticas\TerritorialEstadisticaController;
use App\Http\Controllers\Frontend\Estadisticas\FamiliaEstadisticaController;
use App\Http\Controllers\Frontend\Estadisticas\MercaderiaEstadisticaController;

Route::middleware(['auth'])
    ->prefix('estadisticas')
    ->name('estadisticas.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard General
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [DashboardController::class, 'index']
        )->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Programas / Destinatarios
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/destinatarios',
            [DestinatarioEstadisticaController::class, 'index']
        )->name('destinatarios');

        Route::get(
            '/destinatarios/envion',
            [DestinatarioEstadisticaController::class, 'envion']
        )->name('destinatarios.envion');

        Route::get(
            '/destinatarios/udi',
            [DestinatarioEstadisticaController::class, 'udi']
        )->name('destinatarios.udi');

        Route::get(
            '/destinatarios/guarderia',
            [DestinatarioEstadisticaController::class, 'guarderia']
        )->name('destinatarios.guarderia');

        Route::get(
            '/destinatarios/multiespacio',
            [DestinatarioEstadisticaController::class, 'multiespacio']
        )->name('destinatarios.multiespacio');

        /*
        |--------------------------------------------------------------------------
        | Beneficios
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/beneficios',
            [BeneficioEstadisticaController::class, 'index']
        )->name('beneficios');

        /*
        |--------------------------------------------------------------------------
        | Atenciones
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/atenciones',
            [AtencionEstadisticaController::class, 'index']
        )->name('atenciones');

        /*
        |--------------------------------------------------------------------------
        | Territorial
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/territorial',
            [TerritorialEstadisticaController::class, 'index']
        )->name('territorial');

        /*
        |--------------------------------------------------------------------------
        | Familias
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/familias',
            [FamiliaEstadisticaController::class, 'index']
        )->name('familias');

        /*
        |--------------------------------------------------------------------------
        | Ingresos
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/ingresos',
            [IngresoEstadisticaController::class, 'index']
        )->name('ingresos');

        /*
        |--------------------------------------------------------------------------
        | Mercaderías
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/mercaderias',
            [MercaderiaEstadisticaController::class, 'index']
        )->name('mercaderias');
    });