<?php
use App\Http\Controllers\backend\EnfermedadController;

Route::prefix('backend')->group(function () {
    Route::resource('enfermedades', EnfermedadController::class);
});