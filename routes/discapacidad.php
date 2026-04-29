<?php
use App\Http\Controllers\Backend\DiscapacidadController;

Route::prefix('backend')->group(function () {
    Route::resource('discapacidades', DiscapacidadController::class)->parameters(['discapacidades' => 'discapacidad']);
});