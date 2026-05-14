<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use App\Models\Persona;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::with('persona')
            ->latest()
            ->get();

        return view(
            'frontend.recepcion.ingresos.index',
            compact('ingresos')
        );
    }

    public function create()
    {
        $personas = Persona::orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view(
            'frontend.recepcion.ingresos.create',
            compact('personas')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'persona_texto' => 'required',

            'fecha_ingreso' => 'required',

            'hora_ingreso'  => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | PERSONA EXISTENTE
        |--------------------------------------------------------------------------
        */

        $personaId = null;

        $nombre = null;
        $apellido = null;

        if ($request->persona_id) {

            $personaId = $request->persona_id;

        } else {

            /*
            |--------------------------------------------------------------------------
            | Persona manual
            |--------------------------------------------------------------------------
            */

            $texto = trim($request->persona_texto);

            $partes = preg_split('/\s+/', $texto);

            $apellido = array_shift($partes);

            $nombre = implode(' ', $partes);
        }

        /*
        |--------------------------------------------------------------------------
        | INGRESO
        |--------------------------------------------------------------------------
        */

        Ingreso::create([

            'persona_id'    => $personaId,

            'nombre'        => $nombre,

            'apellido'      => $apellido,

            'fecha_ingreso' => $request->fecha_ingreso,

            'hora_ingreso'  => $request->hora_ingreso,

            'derivacion'    => $request->derivacion,

            'observaciones' => $request->observaciones,

            'user_id'       => auth()->id(),

        ]);

        return redirect()
            ->route('recepcion.ingresos.index')
            ->with('success', 'Ingreso registrado correctamente');
    }
}