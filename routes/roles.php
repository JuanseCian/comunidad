<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\HomeController;

Route::middleware(['auth', 'checkrole:3'])->group(function () {
    Route::get('/admin', [HomeController::class, 'index']);
});

Route::middleware(['auth', 'checkrole:2,3'])->group(function () {
    Route::get('/panel', function () {
        return view('panel.index');
    });
});

Route::middleware(['auth', 'checkrole:1'])->group(function () {
    Route::get('/tecnico', function () {
        return view('tecnico.index');
    });
});