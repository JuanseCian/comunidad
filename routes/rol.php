<?php

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', ...);
});

Route::middleware(['auth', 'role:admin,coordinador'])->group(function () {
    Route::get('/panel', ...);
});

Route::middleware(['auth', 'role:tecnico'])->group(function () {
    Route::get('/tecnico', ...);
});