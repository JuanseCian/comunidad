<?php

use App\Http\Controllers\frontend\HomeController;


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
    