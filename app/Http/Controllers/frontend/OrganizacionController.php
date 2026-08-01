<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Organizacion;
use Illuminate\Http\Request;

class OrganizacionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Organizacion::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('cuit_dni', 'like', "%{$search}%");
            });
        }

        $organizaciones = $query
            ->orderBy('nombre')
            ->paginate(15);

        return view('frontend.recepcion.organizaciones.index', compact('organizaciones'));
    }

    public function create()
    {
        return view('frontend.recepcion.organizaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'cuit_dni'     => 'nullable|string|max:20',
            'responsable'  => 'nullable|string|max:150',
            'telefono'     => 'nullable|string|max:50',
            'direccion'    => 'nullable|string|max:255',
            'cupo_mensual' => 'nullable|integer|min:1',
        ]);

        Organizacion::create($request->only([
            'nombre',
            'cuit_dni',
            'responsable',
            'telefono',
            'direccion',
            'cupo_mensual',
        ]));

        return redirect()
            ->route('recepcion.organizaciones.index')
            ->with('success', 'Organización registrada correctamente.');
    }

    public function edit($id)
    {
        $organizacion = Organizacion::findOrFail($id);

        return view('frontend.recepcion.organizaciones.edit', compact('organizacion'));
    }

    public function update(Request $request, $id)
    {
        $organizacion = Organizacion::findOrFail($id);

        $request->validate([
            'nombre'       => 'required|string|max:255',
            'cuit_dni'     => 'nullable|string|max:20',
            'responsable'  => 'nullable|string|max:150',
            'telefono'     => 'nullable|string|max:50',
            'direccion'    => 'nullable|string|max:255',
            'cupo_mensual' => 'nullable|integer|min:1',
        ]);

        $organizacion->update([
            'nombre'       => $request->nombre,
            'cuit_dni'     => $request->cuit_dni,
            'responsable'  => $request->responsable,
            'telefono'     => $request->telefono,
            'direccion'    => $request->direccion,
            'cupo_mensual' => $request->cupo_mensual,
            'activo'       => $request->boolean('activo'),
        ]);

        return redirect()
            ->route('recepcion.organizaciones.index')
            ->with('success', 'Organización actualizada correctamente.');
    }

    public function destroy($id)
    {
        $organizacion = Organizacion::findOrFail($id);
        $organizacion->update(['activo' => false]);

        return redirect()
            ->route('recepcion.organizaciones.index')
            ->with('success', 'Organización desactivada.');
    }

    /**
     * Autocompletado usado desde el formulario de carga de mercaderías
     * (buscador de organizaciones, análogo a buscarPersonas).
     */
    public function buscar(Request $request)
    {
        $term = trim($request->texto);

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $organizaciones = Organizacion::where('activo', true)
            ->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                    ->orWhere('cuit_dni', 'like', "%{$term}%");
            })
            ->orderBy('nombre')
            ->limit(10)
            ->get(['id', 'nombre', 'cuit_dni', 'cupo_mensual']);

        $organizaciones = $organizaciones->map(function ($org) {
            return [
                'id'              => $org->id,
                'nombre'          => $org->nombre,
                'cuit_dni'        => $org->cuit_dni,
                'cupo_mensual'    => $org->cupo_mensual,
                'cupo_disponible' => $org->cupoDisponible(),
            ];
        });

        return response()->json($organizaciones);
    }
}
