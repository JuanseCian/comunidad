<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\HomeController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

});