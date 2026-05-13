<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\PersonaTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonaTrabajoController extends Controller
{
    
    public function store(Request $request, Persona $persona)
    {
        $request->validate([
            'situacion_ocupacional_id' => 'nullable|exists:situacion_ocupacional,id',
            'categoria_ocupacional_id' => 'nullable|exists:categoria_ocupacional,id',
            'descripcion'              => 'required|string|max:255',
            'empleador'                => 'nullable|string|max:150',
            'cargo'                    => 'nullable|string|max:100',
            'ingresos'                 => 'nullable|numeric|min:0',
            'fecha_inicio'             => 'nullable|date',
            'observaciones'            => 'nullable|string',
        ], [
            'descripcion.required' => 'El tipo/rubro de trabajo es obligatorio.',
        ]);

       
        $persona->trabajos()->actual()->update([
            'fecha_fin'  => now()->toDateString(),
            'updated_by' => Auth::id(),
        ]);

        
        $persona->trabajos()->create([
            'situacion_ocupacional_id' => $request->situacion_ocupacional_id,
            'categoria_ocupacional_id' => $request->categoria_ocupacional_id,
            'descripcion'              => $request->descripcion,
            'empleador'                => $request->empleador,
            'cargo'                    => $request->cargo,
            'ingresos'                 => $request->ingresos,
            'fecha_inicio'             => $request->fecha_inicio ?? now()->toDateString(),
            'observaciones'            => $request->observaciones,
            'created_by'               => Auth::id(),
        ]);

        
        $persona->update(['trabaja' => true]);

        return back()->with('success', 'Trabajo registrado correctamente.');
    }

    
    public function finalizar(Request $request, Persona $persona)
    {
        $actual = $persona->trabajos()->actual()->latest()->first();

        if ($actual) {
            $actual->update([
                'fecha_fin'  => now()->toDateString(),
                'updated_by' => Auth::id(),
            ]);
            $persona->update(['trabaja' => false]);
        }

        return back()->with('success', 'Trabajo finalizado. El historial se conserva.');
    }
}
