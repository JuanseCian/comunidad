<?php
use App\Http\Controllers\frontend\PersonaController;
use App\Http\Controllers\frontend\PersonaProgramaController;
use App\Http\Controllers\frontend\GrupoFamiliarController;
use App\Http\Middleware\CheckRole;

Route::middleware(['auth'])->group(function () {

    Route::middleware([CheckRole::class . ':3'])->group(function () {
        Route::get('/personas/solicitudes', [PersonaController::class, 'solicitudesPendientes'])->name('personas.solicitudes');
        Route::patch('/personas/{id}/aprobar', [PersonaController::class, 'aprobarPersona'])->name('personas.aprobar');
        Route::delete('/personas/{id}/rechazar', [PersonaController::class, 'rechazarPersona'])->name('personas.rechazar');
    });

    Route::middleware([CheckRole::class . ':2,3'])->group(function () {
        
        Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
        Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
        
        Route::get('/personas/{id}/edit', [PersonaController::class, 'edit'])->name('personas.edit');
        Route::put('/personas/{id}', [PersonaController::class, 'update'])->name('personas.update');
        Route::put('/personas/{id}/datos', [PersonaController::class, 'updateDatos'])->name('personas.updateDatos');
        Route::put('/personas/{id}/domicilio', [PersonaController::class, 'updateDomicilio'])->name('personas.updateDomicilio');
        
       Route::get('/grupo-familiar/{grupoFamiliar}/edit', [GrupoFamiliarController::class, 'edit'])->name('grupo-familiar.edit');
        Route::put('/grupo-familiar/{grupoFamiliar}', [GrupoFamiliarController::class, 'update'])->name('grupo-familiar.update');
        Route::post('/persona-programa', [PersonaProgramaController::class, 'store'])->name('persona-programa.store');
        Route::put('/persona-programa/{id}', [PersonaProgramaController::class, 'update'])->name('persona-programa.update');
        Route::post('/personas/{id}/cambiar-programa', [PersonaController::class, 'cambiarPrograma'])->name('personas.cambiarPrograma');
    });

    Route::middleware([CheckRole::class . ':1,2,3'])->group(function () {
        Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
        Route::get('/personas/{id}', [PersonaController::class, 'show'])->name('personas.show');
    });

});