<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use App\Models\Persona;
use App\Models\Derivacion;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::with([
                'persona',
                'derivacion',
                'menor',
                'usuario',
            ])
            ->latest()
            ->get();

        return view(
            'frontend.recepcion.ingresos.index',
            compact('ingresos')
        );
    }

    public function create()
    {
        $derivaciones = Derivacion::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        return view(
            'frontend.recepcion.ingresos.create',
            compact('derivaciones')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_ingreso'  => 'required|date',
            'hora_ingreso'   => 'required',
            'dni'            => 'nullable',
            'apellido'       => 'required',
            'nombre'         => 'required',
            'derivacion_id'  => 'nullable|exists:derivaciones,id',
            'menor_dni'      => 'nullable',
            'menor_apellido' => 'nullable',
            'menor_nombre'   => 'nullable',
        ]);

        Ingreso::create([
            'persona_id'       => $request->persona_id    ?: null,
            'dni'              => $request->dni,
            'apellido'         => $request->apellido,
            'nombre'           => $request->nombre,
            'fecha_ingreso'    => $request->fecha_ingreso,
            'hora_ingreso'     => $request->hora_ingreso,
            'derivacion_id'    => $request->derivacion_id ?: null,
            'observaciones'    => $request->observaciones,
            'menor_persona_id' => $request->menor_persona_id ?: null,
            'menor_dni'        => $request->menor_dni,
            'menor_apellido'   => $request->menor_apellido,
            'menor_nombre'     => $request->menor_nombre,
            'user_id'          => auth()->id(),
        ]);

        return redirect()
            ->route('recepcion.ingresos.index')
            ->with('success', 'Ingreso registrado correctamente.');
    }

    /**
     * Búsqueda de personas para autocomplete (persona principal y menor).
     * Ruta: recepcion.ingresos.buscar-personas
     */
    public function buscarPersonas(Request $request)
    {
        $term = trim($request->texto);

        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        $personas = Persona::query()
            ->where(function ($query) use ($term) {
                $query->whereRaw('CAST(dni AS CHAR) LIKE ?', ["%{$term}%"])
                      ->orWhere('apellido', 'LIKE', "%{$term}%")
                      ->orWhere('nombre',   'LIKE', "%{$term}%");
            })
            ->whereNull('deleted_at')
            ->select(['id', 'nombre', 'apellido', 'dni'])
            ->limit(8)
            ->get();

        return response()->json($personas);
    }
}
