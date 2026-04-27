<?php

use App\Http\Controllers\frontend\HomeController;


Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', function () {
        return view('frontend.home.home');
        })->name('home');
        
});

        Route::get('/', [HomeController::class, 'index'])->name('home');