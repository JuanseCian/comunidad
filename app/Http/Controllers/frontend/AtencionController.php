<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

use App\Models\Atencion;
use App\Models\Persona;
use App\Models\Adjunto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AtencionController extends Controller
{
    public function create(Persona $persona)
    {
        return view('frontend.atenciones.create', compact('persona'));
    }
public function destroy(Atencion $atencion)
{
   
    $atencion->load('adjuntos');

    
    foreach ($atencion->adjuntos as $adjunto) {

       
        if (Storage::disk('local')->exists($adjunto->ruta)) {
            Storage::disk('local')->delete($adjunto->ruta);
        }

       
        $adjunto->delete();
    }

    
    $persona = $atencion->persona;

    
    $atencion->delete();

    return redirect()
        ->route('personas.show', $persona)
        ->with('success', 'Intervención eliminada correctamente.');
}
  public function store(Request $request, Persona $persona)
{
    $request->validate([
        'tipo'           => 'required|in:visita_domiciliaria,entrevista,llamado,derivacion,seguimiento,otro',
        'fecha_atencion' => 'required|date',
        'descripcion'    => 'required|string',
        'archivos'       => 'nullable|array',
        'archivos.*'     => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

    
    $atencion = $persona->atenciones()->create([
        'usuario_id'     => Auth::id(),
        'tipo'           => $request->tipo,
        'fecha_atencion' => $request->fecha_atencion,
        'descripcion'    => $request->descripcion,
    ]);

   
    if ($request->hasFile('archivos')) {
        $this->guardarAdjuntos($request->file('archivos'), $persona->id, $atencion->id);
    }

    return redirect()
        ->route('personas.show', $persona)
        ->with('success', 'Intervención registrada correctamente.');
}
 public function edit(Atencion $atencion)
    {
       
        $atencion->load('adjuntos');
 
        return view('frontend.atenciones.edit', compact('atencion'));
    }
 

public function update(Request $request, Atencion $atencion)
{
    $request->validate([
        'tipo'           => 'required|in:visita_domiciliaria,entrevista,llamado,derivacion,seguimiento,otro',
        'fecha_atencion' => 'required|date',
        'descripcion'    => 'required|string',
        'archivos'       => 'nullable|array',
        'archivos.*'     => 'file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

   
    $atencion->update([
        'tipo'           => $request->tipo,
        'fecha_atencion' => $request->fecha_atencion,
        'descripcion'    => $request->descripcion,
    ]);

   
    if ($request->hasFile('archivos')) {
        $this->guardarAdjuntos(
            $request->file('archivos'),
            $atencion->persona_id,
            $atencion->id
        );
    }

    return redirect()
        ->route('atenciones.edit', $atencion)
        ->with('success', 'Intervención actualizada correctamente.');
}
public function show(Atencion $atencion)
{
    $atencion->load(['adjuntos', 'users', 'persona']);

    return view('frontend.atenciones.show', compact('atencion'));
}

private function guardarAdjuntos(array $archivos, int $personaId, int $atencionId): void
{
    $carpeta = "adjuntos/persona_{$personaId}/atencion_{$atencionId}";

    foreach ($archivos as $archivo) {
        $extension      = $archivo->getClientOriginalExtension();
        $nombreGuardado = Str::uuid() . '.' . $extension;
        $ruta           = $carpeta . '/' . $nombreGuardado;

        Storage::disk('local')->put($ruta, file_get_contents($archivo));

        Adjunto::create([
            'entidad_tipo'    => 'atencion',
            'entidad_id'      => $atencionId,
            'nombre_original' => $archivo->getClientOriginalName(),
            'nombre_guardado' => $nombreGuardado,
            'ruta'            => $ruta,
            'tipo_mime'       => $archivo->getMimeType(),
            'tamaño'          => $archivo->getSize(),
            'confidencial'    => 0,
            'hash_sha256'     => hash_file('sha256', $archivo->getRealPath()),
            'subido_por'      => Auth::id(),
        ]);
    }
}

}