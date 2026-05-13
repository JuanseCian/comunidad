<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;
use App\Models\Beneficio;
use App\Models\PersonaBeneficio;

class PersonaBeneficioController extends Controller
{
    public function store(Request $request, $personaId)
    {
        $request->validate([
            'beneficio_id'      => 'required|exists:beneficios,id',
            'fecha_otorgamiento'=> 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'monto'             => 'nullable|numeric',
            'observaciones'     => 'nullable|string|max:5000',
        ]);

        $persona = Persona::findOrFail($personaId);

        $existe = PersonaBeneficio::where('persona_id', $persona->id)
            ->where('beneficio_id', $request->beneficio_id)
            ->where('activo', 1)
            ->exists();

        if ($existe) {
            return back()->with('warning', 'La persona ya posee este beneficio activo.');
        }

        PersonaBeneficio::create([
            'persona_id'         => $persona->id,
            'beneficio_id'       => $request->beneficio_id,
            'fecha_otorgamiento' => $request->fecha_otorgamiento ?? now(),
            'fecha_vencimiento'  => $request->fecha_vencimiento,
            'monto'              => $request->monto,
            'activo'             => 1,
            'observaciones'      => $request->observaciones,
            'registrado_por'     => auth()->id(),
        ]);

        return back()->with('success', 'Beneficio asignado correctamente.');
    }

    public function destroy($id)
    {
        $personaBeneficio = PersonaBeneficio::findOrFail($id);

        $personaBeneficio->delete();

        return back()->with('success', 'Beneficio eliminado correctamente.');
    }

    public function desactivar($id)
    {
        $personaBeneficio = PersonaBeneficio::findOrFail($id);

        $personaBeneficio->update([
            'activo' => 0
        ]);

        return back()->with('success', 'Beneficio desactivado.');
    }

    public function activar($id)
    {
        $personaBeneficio = PersonaBeneficio::findOrFail($id);

        $personaBeneficio->update([
            'activo' => 1
        ]);

        return back()->with('success', 'Beneficio activado.');
    }
}