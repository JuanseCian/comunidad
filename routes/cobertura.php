<?php
use App\Http\Controllers\Backend\CoberturaController;

Route::prefix('backend')->group(function () {
    Route::resource('coberturas', CoberturaController::class);
});