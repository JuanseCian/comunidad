<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Adjunto;

use App\Models\Atencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdjuntoController extends Controller
{
    
    public function download(Adjunto $adjunto)
    {
        abort_unless(
            Storage::disk('local')->exists($adjunto->ruta),
            404,
            'Archivo no encontrado.'
        );

        return Storage::disk('local')->download(
            $adjunto->ruta,
            $adjunto->nombre_original
        );
    }

   
    public function destroy(Adjunto $adjunto)
    {
        if (Storage::disk('local')->exists($adjunto->ruta)) {
            Storage::disk('local')->delete($adjunto->ruta);
        }

        $adjunto->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }
}
