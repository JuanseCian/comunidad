<?php
use App\Http\Controllers\backend\BarrioController;

Route::prefix('backend')->group(function () {
    Route::resource('barrios', BarrioController::class);
});