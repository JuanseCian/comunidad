<?php
use App\Http\Controllers\frontend\FamiliaController;

Route::prefix('familias')
    ->name('familias.')
    ->group(function () {

        Route::get('/', [FamiliaController::class, 'index'])
            ->name('index');

        Route::get('/{id}', [FamiliaController::class, 'show'])
            ->name('show');

    }); 