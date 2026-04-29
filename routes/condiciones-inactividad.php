<?php
use App\Http\Controllers\backend\CondicionInactividadController;

Route::prefix('backend')->group(function () {
    Route::resource('condiciones-inactividad', CondicionInactividadController::class)->parameters(['condiciones-inactividad' => 'condicion_inactividad']);
});