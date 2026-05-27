<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mercaderia;
use App\Models\Persona;

class MercaderiaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $mercaderias = Mercaderia::with([
                'persona',
                'familia',
                'usuario'
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('apellido', 'like', "%{$search}%")
                      ->orWhere('dni', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view(
            'frontend.recepcion.mercaderias.index',
            compact('mercaderias')
        );
    }

    public function create()
    {
        return view('frontend.recepcion.mercaderias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'apellido'      => 'required',
            'nombre'        => 'required',
            'fecha_entrega' => 'required|date',
        ]);

        // Resolver familia_id desde la persona vinculada (si existe)
        $familiaId = null;

        if ($request->persona_id) {
            $persona = Persona::find($request->persona_id);
            if ($persona && $persona->familia_id) {
                $familiaId = $persona->familia_id;
            }
        }

        // Verificar si la familia ya retiró este mes
        if ($familiaId) {
            $fechaEntrega = \Carbon\Carbon::parse($request->fecha_entrega);

            $yaRetiro = Mercaderia::where('familia_id', $familiaId)
                ->whereMonth('fecha_entrega', $fechaEntrega->month)
                ->whereYear('fecha_entrega', $fechaEntrega->year)
                ->exists();

            if ($yaRetiro) {
                return back()
                    ->withInput()
                    ->with('error', 'Esta familia ya retiró mercadería este mes.');
            }
        }

        Mercaderia::create([
            'persona_id'    => $request->persona_id ?: null,
            'familia_id'    => $familiaId,
            'user_id'       => auth()->id(),
            'dni'           => $request->dni,
            'apellido'      => $request->apellido,
            'nombre'        => $request->nombre,
            'fecha_entrega' => $request->fecha_entrega,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('recepcion.mercaderias.index')
            ->with('success', 'Entrega registrada correctamente.');
    }

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
                      ->orWhere('nombre', 'LIKE', "%{$term}%");
            })
            ->select(['id', 'nombre', 'apellido', 'dni', 'familia_id'])
            ->limit(8)
            ->get()
            ->map(function ($persona) {
                // Indicar si la familia ya retiró este mes
                $familiaYaRetiro = false;

                if ($persona->familia_id) {
                    $familiaYaRetiro = Mercaderia::where('familia_id', $persona->familia_id)
                        ->whereMonth('fecha_entrega', now()->month)
                        ->whereYear('fecha_entrega', now()->year)
                        ->exists();
                }

                return [
                    'id'               => $persona->id,
                    'nombre'           => $persona->nombre,
                    'apellido'         => $persona->apellido,
                    'dni'              => $persona->dni,
                    'familia_id'       => $persona->familia_id,
                    'familia_ya_retiro' => $familiaYaRetiro,
                ];
            });

        return response()->json($personas);
    }

    public function readonlyIndex(Request $request)
    {
        $query = Mercaderia::with(['familia', 'usuario']);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%")
                ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        $mercaderias = $query
            ->latest()
            ->paginate(20);

        $readonly = true;

        return view(
            'frontend.recepcion.mercaderias.index',
            compact('mercaderias', 'readonly')
        );
    }
}
