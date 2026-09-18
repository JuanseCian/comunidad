<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\EntregaAbrigo;
use App\Models\Persona;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EntregaAbrigoController extends Controller
{
    public function index(Request $request)
    {
        $query = EntregaAbrigo::with(['persona', 'familia', 'usuario']);
        $this->applyFilters($query, $request);

        $entregas = $query
            ->orderByDesc('fecha_entrega')
            ->orderByDesc('id')
            ->paginate(15);

        return view('frontend.recepcion.abrigo.index', compact('entregas'));
    }

    public function create()
    {
        return view('frontend.recepcion.abrigo.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validateData($request);

        EntregaAbrigo::create($this->dataForSave($datos));

        return redirect()
            ->route('recepcion.abrigo.index')
            ->with('success', 'Entrega de colchones y frazadas registrada correctamente.');
    }

    public function show(EntregaAbrigo $abrigo)
    {
        $abrigo->load(['persona', 'familia', 'usuario']);

        return view('frontend.recepcion.abrigo.show', compact('abrigo'));
    }

    public function edit(EntregaAbrigo $abrigo)
    {
        return view('frontend.recepcion.abrigo.edit', compact('abrigo'));
    }

    public function update(Request $request, EntregaAbrigo $abrigo)
    {
        $datos = $this->validateData($request);
        $abrigo->update($this->dataForSave($datos));

        return redirect()
            ->route('recepcion.abrigo.index')
            ->with('success', 'Entrega de abrigo actualizada correctamente.');
    }

    public function imprimir(Request $request)
    {
        $query = EntregaAbrigo::query();
        $this->applyFilters($query, $request);

        $entregas = $query
            ->orderByDesc('fecha_entrega')
            ->orderByDesc('id')
            ->get();

        return view('frontend.recepcion.abrigo.imprimir', compact('entregas'));
    }

    public function buscarPersonas(Request $request)
    {
        $term = trim((string) $request->input('texto'));

        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $personas = Persona::with('domicilio')
            ->where(function (Builder $query) use ($term) {
                if (is_numeric($term)) {
                    $query->where('dni', $term)->orWhere('dni', 'like', "{$term}%");
                }

                $query->orWhere('apellido', 'like', "%{$term}%")
                    ->orWhere('nombre', 'like', "%{$term}%")
                    ->orWhereRaw("CONCAT(apellido, ' ', nombre) LIKE ?", ["%{$term}%"])
                    ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$term}%"]);
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->limit(10)
            ->get(['id', 'nombre', 'apellido', 'dni', 'familia_id']);

        return response()->json($personas->map(function (Persona $persona) {
            return [
                'id' => $persona->id,
                'nombre' => $persona->nombre,
                'apellido' => $persona->apellido,
                'dni' => $persona->dni,
                'familia_id' => $persona->familia_id,
                'direccion' => $persona->domicilio
                    ? trim(($persona->domicilio->calle ?? '') . ' ' . ($persona->domicilio->altura ?? ''))
                    : null,
            ];
        }));
    }

    private function validateData(Request $request): array
    {
        $datos = $request->validate([
            'persona_id' => 'nullable|exists:personas,id',
            'dni' => 'nullable|string|max:50',
            'apellido' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'colchones' => 'required|integer|min:0',
            'frazadas' => 'required|integer|min:0',
            'fecha_entrega' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        if ((int) $datos['colchones'] + (int) $datos['frazadas'] === 0) {
            throw ValidationException::withMessages([
                'colchones' => 'Indicá al menos un colchón o una frazada.',
            ]);
        }

        if (!empty($datos['persona_id'])) {
            $datos['familia_id'] = Persona::whereKey($datos['persona_id'])->value('familia_id');
        } else {
            $datos['familia_id'] = null;
        }

        return $datos;
    }

    private function dataForSave(array $datos): array
    {
        return [
            'persona_id' => $datos['persona_id'] ?? null,
            'familia_id' => $datos['familia_id'] ?? null,
            'user_id' => auth()->id(),
            'dni' => $datos['dni'] ?? null,
            'apellido' => $datos['apellido'],
            'nombre' => $datos['nombre'],
            'direccion' => $datos['direccion'] ?? null,
            'colchones' => $datos['colchones'],
            'frazadas' => $datos['frazadas'],
            'fecha_entrega' => $datos['fecha_entrega'],
            'observaciones' => $datos['observaciones'] ?? null,
        ];
    }

    private function applyFilters(Builder $query, Request $request): Builder
    {
        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function (Builder $builder) use ($search) {
                $builder->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        if ($request->filled('producto') && in_array($request->producto, ['colchones', 'frazadas'], true)) {
            $query->where($request->producto, '>', 0);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_entrega', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_entrega', '<=', $request->fecha_hasta);
        }

        return $query;
    }
}
