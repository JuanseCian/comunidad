<?php
 
// ─────────────────────────────────────────────────────────────────────────────
// Agregar dentro del grupo de middleware 'auth' en routes/web.php
// ─────────────────────────────────────────────────────────────────────────────
 
use App\Http\Controllers\frontend\AdjuntoController;
 
// Descargar un adjunto
Route::get('adjuntos/{adjunto}/descargar', [AdjuntoController::class, 'download'])
     ->name('adjuntos.download');
 
// Eliminar un adjunto
Route::delete('adjuntos/{adjunto}', [AdjuntoController::class, 'destroy'])
     ->name('adjuntos.destroy');