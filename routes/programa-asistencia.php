<?php
use App\Http\Controllers\backend\ProgramaAsistenciaController;
use App\Http\Controllers\frontend\ProgramaController;


Route::resource('programas-asistencia', ProgramaAsistenciaController::class);


//frontend
Route::get('/programas/{id}', [ProgramaController::class, 'show'])
    ->name('frontend.programas.show');