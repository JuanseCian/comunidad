<?php

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('frontend.home.home');
    })->name('home');

});