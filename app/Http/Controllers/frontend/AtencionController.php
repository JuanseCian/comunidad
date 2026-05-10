<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Atenciones;
use App\Models\Persona;
use Illuminate\Http\Request;

class AtencionController extends Controller
{
    public function create(Persona $persona)
    {
        return view('frontend.atenciones.create', compact('persona'));
    }

    public function store(Request $request, Persona $persona)
    {
        $request->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required|date',
        ]);

        Atenciones::create([
            'persona_id' => $persona->id,
            'usuario_id' => auth()->id(),
            'sede_id' => auth()->user()->sede_id ?? null,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'fecha_atencion' => $request->fecha,
        ]);

        return redirect()
            ->route('personas.show', $persona)
            ->with('success', 'Intervención registrada correctamente');
    }

    public function edit(Atenciones $atencion)
    {
        return view('frontend.atenciones.edit', compact('atencion'));
    }

    public function update(Request $request, Atenciones $atencion)
    {
        $request->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required|date',
        ]);

        $atencion->update([
                'tipo' => $request->tipo,
                'descripcion' => $request->descripcion,
                'fecha_atencion' => $request->fecha,
            ]);

        return redirect()
            ->route('personas.show', $atencion->persona)
            ->with('success', 'Intervención actualizada correctamente');
    }

    public function show($id)
    {
        $atencion = Atenciones::with(['persona', 'users'])->findOrFail($id);

        return view('frontend.atenciones.show', compact('atencion'));
    }

    public function destroy(Atencion $atencion)
    {
        $persona = $atencion->persona;

        $atencion->delete();

        return redirect()
            ->route('personas.show', $persona)
            ->with('success', 'Intervención eliminada');
    }
}