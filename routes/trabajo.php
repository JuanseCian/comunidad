<?php

// ─────────────────────────────────────────────────────────────────────────────
// Agregar dentro del grupo auth + CheckRole:2,3,5 en routes/web.php o persona.php
// ─────────────────────────────────────────────────────────────────────────────

use App\Http\Controllers\frontend\PersonaTrabajoController;


Route::post('/personas/{persona}/trabajo', [PersonaTrabajoController::class, 'store'])
     ->name('personas.trabajo.store');


Route::patch('/personas/{persona}/trabajo/finalizar', [PersonaTrabajoController::class, 'finalizar'])
     ->name('personas.trabajo.finalizar');
