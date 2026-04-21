<?php

use App\Http\Controllers\backend\ProvinciaController;

Route::prefix('backend')->group(function () {
    Route::resource('provincias', ProvinciaController::class);
});