<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonaPrograma;

class PersonaProgramaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'persona_id'   => 'required|exists:personas,id',
            'programa_id'  => 'required|exists:programas_asistencia,id',
            'sede_id'      => 'nullable|exists:sedes,id',
            'rol'          => 'required|in:destinatario,tutor',

            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',

            'observaciones'=> 'nullable|string',

            'en_adaptacion' => 'nullable|boolean',

            'fecha_limite_adaptacion' =>
                'required_if:en_adaptacion,1|nullable|date',
        ]);

        $programa = \App\Models\ProgramasAsistencia::findOrFail($request->programa_id);

        if (
            strtolower($programa->nombre) !== 'multiespacio'
            && !$request->sede_id
        ) {
            return back()->withErrors([
                'sede_id' => 'Debe seleccionar una sede.'
            ]);
        }

        PersonaPrograma::create([
            'persona_id'   => $request->persona_id,
            'programa_id'  => $request->programa_id,
            'sede_id'      => $request->sede_id,

            'rol'          => $request->rol,

            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,

            'observaciones'=> $request->observaciones,

            'en_adaptacion' =>
                $request->has('en_adaptacion') ? 1 : 0,

            'fecha_limite_adaptacion' =>
                $request->has('en_adaptacion')
                    ? $request->fecha_limite_adaptacion
                    : null,
        ]);

        return back()->with(
            'success',
            'Programa asignado correctamente'
        );
    }

    public function update(Request $request, $id)
    {
        $pp = PersonaPrograma::findOrFail($id);

        $request->validate([
            'en_adaptacion' => 'nullable|boolean',
            'fecha_limite_adaptacion' => 'required_if:en_adaptacion,1|nullable|date',
        ]);

        $pp->update([
            'rol' => $request->rol,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'en_adaptacion' => $request->has('en_adaptacion') ? 1 : 0,
            'fecha_limite_adaptacion' => $request->has('en_adaptacion') ? $request->fecha_limite_adaptacion : null,
        ]);

        if ($request->fecha_fin && $request->fecha_fin < $request->fecha_inicio) {
            return back()->with('error', 'La fecha fin no puede ser menor a inicio');
        }

        return back()->with('success', 'Programa actualizado');
    }

    public function asignarPrograma(Request $request)
    {
        $data = $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'programa_id' => 'required|exists:programas_asistencia,id',
            'en_adaptacion' => 'nullable|boolean',
            'fecha_limite_adaptacion' => 'required_if:en_adaptacion,1|nullable|date',            
            'observaciones' => 'nullable|string',
        ]);

        PersonaPrograma::create([
            'persona_id' => $data['persona_id'],
            'programa_id' => $data['programa_id'],
            'fecha_inicio' => now(),
            'en_adaptacion' => $request->has('en_adaptacion'),
            'fecha_limite_adaptacion' => $request->input('fecha_limite'),
            'activo' => 1,
            'observaciones' => $data['observaciones'],
        ]);

        return redirect()->back()->with('success', 'Persona asignada correctamente.');
    }
}