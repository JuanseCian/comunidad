<?php
use App\Http\Controllers\backend\BeneficioController;
use App\Http\Controllers\frontend\PersonaBeneficioController;

Route::resource('beneficios', BeneficioController::class);

//Beneficio en el Frontend para personas
Route::post(
    '/personas/{persona}/beneficios',
    [PersonaBeneficioController::class, 'store']
)->name('personas.beneficios.store');

Route::delete(
    '/persona-beneficios/{id}',
    [PersonaBeneficioController::class, 'destroy']
)->name('persona-beneficios.destroy');

Route::patch(
    '/persona-beneficios/{id}/desactivar',
    [PersonaBeneficioController::class, 'desactivar']
)->name('persona-beneficios.desactivar');

Route::patch(
    '/persona-beneficios/{id}/activar',
    [PersonaBeneficioController::class, 'activar']
)->name('persona-beneficios.activar');