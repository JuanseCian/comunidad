<?php

use App\Http\Controllers\frontend\AtencionController;
use App\Http\Middleware\CheckRole;
use App\Models\Atencion;

Route::middleware(['auth'])->group(function () {

    Route::middleware([CheckRole::class . ':1,2,3,5'])->group(function () {

        Route::get('/personas/{persona}/atenciones', [AtencionController::class, 'index'])
            ->name('atenciones.index');

    });

    Route::middleware([CheckRole::class . ':2,3,5'])->group(function () {

        Route::get('/personas/{persona}/atenciones/create', [AtencionController::class, 'create'])
            ->name('atenciones.create');

        Route::post('/personas/{persona}/atenciones', [AtencionController::class, 'store'])
            ->name('atenciones.store');

        Route::get('/atenciones/{atencion}/edit', [AtencionController::class, 'edit'])
            ->name('atenciones.edit');

        Route::put('/atenciones/{atencion}', [AtencionController::class, 'update'])
            ->name('atenciones.update');

        Route::delete('/atenciones/{atencion}', [AtencionController::class, 'destroy'])
            ->name('atenciones.destroy');
    });

    Route::get('/atenciones/{atencion}', [AtencionController::class, 'show'])
        ->name('atenciones.show');
});
