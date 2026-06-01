<?php
use App\Http\Controllers\backend\BeneficioController;
use App\Http\Controllers\frontend\PersonaBeneficioController;
use App\Http\Controllers\frontend\PlanMasVidaController;    

Route::resource('beneficios', BeneficioController::class);


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

//Ruta para Mas Vida
Route::get(
    '/plan-mas-vida/{personaBeneficio}/create',
    [PlanMasVidaController::class, 'create']
)->name('plan-mas-vida.create');

Route::post(
    '/plan-mas-vida/{personaBeneficio}',
    [PlanMasVidaController::class, 'store']
)->name('plan-mas-vida.store');

Route::get(
    '/plan-mas-vida/{id}',
    [PlanMasVidaController::class, 'show']
)->name('plan-mas-vida.show');

Route::get(
    '/plan-mas-vida/{id}/edit',
    [PlanMasVidaController::class, 'edit']
)->name('plan-mas-vida.edit');

Route::put(
    '/plan-mas-vida/{id}',
    [PlanMasVidaController::class, 'update']
)->name('plan-mas-vida.update');

Route::get(
    '/plan-mas-vida/{id}/pdf',
    [PlanMasVidaController::class, 'pdf']
)->name('plan-mas-vida.pdf');