<?php

use App\Http\Controllers\frontend\HomeController;


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/manuales/manual-usuario.pdf', function () {
        $manualPath = public_path('manuales/manual-usuario.pdf');

        abort_unless(is_file($manualPath), 404);

        return response()->file($manualPath, [
            'Content-Type' => 'application/pdf',
        ]);
    })->name('manual.usuario');
});
