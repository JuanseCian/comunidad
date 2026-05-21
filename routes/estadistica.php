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
        Route::get(
            '/',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/ingresos',
            [IngresoEstadisticaController::class, 'index']
        )->name('ingresos');

        Route::get(
            '/destinatarios',
            [DestinatarioEstadisticaController::class, 'index']
        )->name('destinatarios');

        Route::get(
            '/beneficios',
            [BeneficioEstadisticaController::class, 'index']
        )->name('beneficios');

        Route::get(
            '/atenciones',
            [AtencionEstadisticaController::class, 'index']
        )->name('atenciones');

        Route::get(
            '/territorial',
            [TerritorialEstadisticaController::class, 'index']
        )->name('territorial');

        Route::get(
            '/familias',
            [FamiliaEstadisticaController::class, 'index']
        )->name('familias');

        Route::get(
            '/mercaderias',
            [MercaderiaEstadisticaController::class, 'index']
        )->name('mercaderias');
});