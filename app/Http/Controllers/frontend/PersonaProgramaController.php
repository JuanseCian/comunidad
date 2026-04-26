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
            'fecha_inicio' => 'nullable|date',
            'observaciones'=> 'nullable|string'
        ]);

        PersonaPrograma::create([
            'persona_id'   => $request->persona_id,
            'programa_id'  => $request->programa_id,
            'fecha_inicio' => $request->fecha_inicio,
            'observaciones'=> $request->observaciones,
        ]);

        return back()->with('success', 'Programa asignado correctamente');
    }
}