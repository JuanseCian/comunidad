<?php

use App\Http\Controllers\backend\LocalidadController;

Route::prefix('backend')->group(function () {
    Route::resource('localidades', LocalidadController::class);
});