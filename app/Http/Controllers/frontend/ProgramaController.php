<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\ProgramasAsistencia;

class ProgramaController extends Controller
{
    public function show(Request $request, $id)
    {
        $programa = ProgramasAsistencia::findOrFail($id);

        $query = $programa->personas()
            ->with([
                'sexo',
                'personaPrograma.sede'
            ]);

        // BUSCADOR
        if ($request->filled('q')) {

            $q = trim($request->q);

            $query->where(function ($sql) use ($q) {

                $sql->where('nombre', 'like', "%{$q}%")
                    ->orWhere('apellido', 'like', "%{$q}%")
                    ->orWhere('dni', 'like', "%{$q}%");

            });
        }

        // FILTRO SEDE
        if ($request->filled('sede_id')) {

            $query->whereHas('personaPrograma', function ($sql) use ($request, $id) {

                $sql->where('programa_id', $id)
                    ->where('sede_id', $request->sede_id);

            });
        }

        // FILTRO ESTADO
        if ($request->filled('estado_programa')) {

            if ($request->estado_programa == 'activo') {

                $query->whereHas('personaPrograma', function ($sql) use ($id) {
                    $sql->where('programa_id', $id)
                        ->whereNull('fecha_fin');
                });

            } elseif ($request->estado_programa == 'finalizado') {

                $query->whereHas('personaPrograma', function ($sql) use ($id) {
                    $sql->where('programa_id', $id)
                        ->whereNotNull('fecha_fin');
                });

            }
        }

        $personas = $query
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(20)
            ->withQueryString();

        $sedes = \App\Models\Sede::where('activa', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('frontend.programas.show', compact(
            'programa',
            'personas',
            'sedes'
        ));
    }
}
