<?php
 
// ─────────────────────────────────────────────────────────────────────────────
// Agregar dentro del grupo de middleware 'auth' en routes/web.php
// ─────────────────────────────────────────────────────────────────────────────
 
use App\Http\Controllers\frontend\AdjuntoController;
 

Route::get('adjuntos/{adjunto}/descargar', [AdjuntoController::class, 'download'])
     ->name('adjuntos.download');
 

Route::delete('adjuntos/{adjunto}', [AdjuntoController::class, 'destroy'])
     ->name('adjuntos.destroy');