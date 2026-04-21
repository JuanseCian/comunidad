<?php

use App\Http\Controllers\backend\ZonaBarrioController;

Route::prefix('backend')->group(function () {
    Route::resource('zonas-barrios', ZonaBarrioController::class);
});