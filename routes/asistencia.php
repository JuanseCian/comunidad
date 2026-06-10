<?php

use App\Http\Controllers\frontend\AsistenciaController;

Route::middleware('auth')->group(function () {

    Route::get(
        '/asistencia/seleccionar',
        [AsistenciaController::class, 'seleccionar']
    )->name('asistencia.seleccionar');

    Route::get(
        '/asistencia',
        [AsistenciaController::class, 'index']
    )->name('asistencia.index');

    Route::post(
        '/asistencia/guardar',
        [AsistenciaController::class, 'guardar']
    )->name('asistencia.guardar');

    Route::post(
        '/asistencia/toggle',
        [AsistenciaController::class, 'toggle']
    )->name('asistencia.toggle');

    Route::get(
        '/asistencia/historial/{persona}',
        [AsistenciaController::class, 'historial']
    )->name('asistencia.historial');
});