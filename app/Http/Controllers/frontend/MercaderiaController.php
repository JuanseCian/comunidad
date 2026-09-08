<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mercaderia;
use App\Models\Persona;
use App\Models\Organizacion;
use Illuminate\Database\Eloquent\Builder;

class MercaderiaController extends Controller
{

    public function index(Request $request)
    {
        $query = Mercaderia::with([
            'persona',
            'familia',
            'organizacion',
            'usuario'
        ]);

        $this->applyFilters($query, $request);

        $mercaderias = $query
            ->orderByDesc('fecha_entrega')
            ->orderByDesc('id')
            ->paginate(15);

        return view(
            'frontend.recepcion.mercaderias.index',
            [
                'mercaderias' => $mercaderias,
                'tipoFiltro' => $request->input('tipo_filtro'),
                'mes' => $request->input('mes'),
                'anio' => $request->input('anio'),
            ]
        );
    }

    public function imprimir(Request $request)
    {
        $query = Mercaderia::with(['organizacion']);

        $this->applyFilters($query, $request);

        $mercaderias = $query
            ->orderByDesc('fecha_entrega')
            ->orderByDesc('id')
            ->get();

        return view(
            'frontend.recepcion.mercaderias.imprimir',
            compact('mercaderias')
        );
    }

    private function applyFilters(Builder $query, Request $request): Builder
    {
        $search = trim((string) $request->input('search'));
        $tipoFiltro = $request->input('tipo_filtro');
        $mes = (int) $request->input('mes');
        $anio = (int) $request->input('anio');

        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        if ($tipoFiltro === 'mes' && $mes >= 1 && $mes <= 12) {
            $query->whereMonth('fecha_entrega', $mes)
                ->whereYear('fecha_entrega', $anio ?: now()->year);
        }

        if ($tipoFiltro === 'semana') {
            $query->whereBetween('fecha_entrega', [
                now()->startOfWeek()->startOfDay(),
                now()->endOfWeek()->endOfDay(),
            ]);
        }

        if ($tipoFiltro === 'anio') {
            $query->whereYear('fecha_entrega', $anio ?: now()->year);
        }

        return $query;
    }

    public function create()
    {
        return view('frontend.recepcion.mercaderias.create');
    }

    public function store(Request $request)
    {
        if ($request->tipo === 'organizacion') {
            return $this->storeOrganizacion($request);
        }

        $request->validate([
            'apellido'      => 'required',
            'nombre'        => 'required',
            'fecha_entrega' => 'required|date',
            'direccion' => 'nullable|string|max:255',
        ]);

        $familiaId = null;

        if ($request->persona_id) {
            $persona = Persona::find($request->persona_id);
            if ($persona && $persona->familia_id) {
                $familiaId = $persona->familia_id;
            }
        }

        if ($familiaId) {
            $fechaEntrega = \Carbon\Carbon::parse($request->fecha_entrega);

            $ultimoRetiro = Mercaderia::where('familia_id', $familiaId)
                ->orderByDesc('fecha_entrega')
                ->value('fecha_entrega');

            if ($ultimoRetiro) {
                $diasTranscurridos = \Carbon\Carbon::parse($ultimoRetiro)
                    ->diffInDays($fechaEntrega, false);

                if ($diasTranscurridos < 30) {
                    $diasRestantes = 30 - (int) $diasTranscurridos;
                    $proximaFecha  = \Carbon\Carbon::parse($ultimoRetiro)
                        ->addDays(30)
                        ->locale('es')
                        ->isoFormat('D [de] MMMM [de] YYYY');

                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            "Esta familia retiró mercadería hace {$diasTranscurridos} día(s). " .
                            "Podrá retirar nuevamente el {$proximaFecha} " .
                            "({$diasRestantes} día(s) restante(s))."
                        );
                }
            }
        }

        Mercaderia::create([
            'persona_id'    => $request->persona_id ?: null,
            'familia_id'    => $familiaId,
            'user_id'       => auth()->id(),
            'dni'           => $request->dni,
            'direccion'     => $request->direccion,
            'apellido'      => $request->apellido,
            'nombre'        => $request->nombre,
            'cantidad'      => 1,
            'fecha_entrega' => $request->fecha_entrega,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('recepcion.mercaderias.index')
            ->with('success', 'Entrega registrada correctamente.');
    }

    /**
     * Registra una entrega de uno o más bolsones a una organización.
     * No aplica la restricción de 30 días (esa es propia del circuito
     * persona/familia); en cambio, respeta el cupo_mensual de la
     * organización si tiene uno configurado.
     */
    protected function storeOrganizacion(Request $request)
    {
        $request->validate([
            'organizacion_id' => 'required|exists:organizaciones,id',
            'fecha_entrega'   => 'required|date',
            'cantidad'        => 'required|integer|min:1',
        ]);

        $organizacion = Organizacion::findOrFail($request->organizacion_id);

        if ($organizacion->cupo_mensual) {
            $fecha = \Carbon\Carbon::parse($request->fecha_entrega);

            $entregadoEsteMes = $organizacion->bolsonesEntregados(
                $fecha->month,
                $fecha->year
            );

            if ($entregadoEsteMes + (int) $request->cantidad > $organizacion->cupo_mensual) {
                $disponible = max(0, $organizacion->cupo_mensual - $entregadoEsteMes);

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "{$organizacion->nombre} ya recibió {$entregadoEsteMes} de " .
                        "{$organizacion->cupo_mensual} bolsones este mes. " .
                        "Cupo disponible: {$disponible}."
                    );
            }
        }

        Mercaderia::create([
            'organizacion_id' => $organizacion->id,
            'user_id'         => auth()->id(),
            'apellido'        => $organizacion->nombre,
            'nombre'          => 'Organización',
            'cantidad'        => $request->cantidad,
            'fecha_entrega'   => $request->fecha_entrega,
            'observaciones'   => $request->observaciones,
        ]);

        return redirect()
            ->route('recepcion.mercaderias.index')
            ->with('success', 'Entrega a organización registrada correctamente.');
    }

    public function buscarPersonas(Request $request)
    {
        $term = trim($request->texto);

        if (empty($term) || strlen($term) < 2) {
            return response()->json([]);
        }

        $personas = Persona::with('domicilio')
            ->where(function ($query) use ($term) {

                if (is_numeric($term)) {
                    $query->where('dni', $term)
                        ->orWhere('dni', 'LIKE', "{$term}%");
                }

                $query->orWhere('apellido', 'LIKE', "%{$term}%")

                    ->orWhere('nombre', 'LIKE', "%{$term}%")

                    ->orWhereRaw(
                        "CONCAT(apellido,' ',nombre) LIKE ?",
                        ["%{$term}%"]
                    )

                    ->orWhereRaw(
                        "CONCAT(nombre,' ',apellido) LIKE ?",
                        ["%{$term}%"]
                    );
            })

            ->when(is_numeric($term), function ($query) use ($term) {
                $query->orderByRaw("
                    CASE
                        WHEN dni = ? THEN 0
                        WHEN dni LIKE ? THEN 1
                        ELSE 2
                    END
                ", [$term, "{$term}%"]);
            })

            ->orderBy('apellido')
            ->orderBy('nombre')

            ->select([
                'id',
                'nombre',
                'apellido',
                'dni',
                'familia_id'
            ])

            ->limit(10)
            ->get();

        $personas = $personas->map(function ($persona) {

            $familiaYaRetiro = false;
            $diasDesdeRetiro = null;

            if ($persona->familia_id) {

                $ultimoRetiro = Mercaderia::where('familia_id', $persona->familia_id)
                    ->orderByDesc('fecha_entrega')
                    ->value('fecha_entrega');

                if ($ultimoRetiro) {

                    $dias = \Carbon\Carbon::parse($ultimoRetiro)
                        ->diffInDays(now(), false);

                    if ($dias < 30) {
                        $familiaYaRetiro = true;
                        $diasDesdeRetiro = (int) $dias;
                    }
                }
            }

            return [
                'id'                => $persona->id,
                'nombre'            => $persona->nombre,
                'apellido'          => $persona->apellido,
                'dni'               => $persona->dni,
                'direccion'         => $persona->domicilio
                    ? trim(
                        ($persona->domicilio->calle ?? '') . ' ' .
                        ($persona->domicilio->altura ?? '')
                    )
                    : null,
                'familia_id'        => $persona->familia_id,
                'familia_ya_retiro' => $familiaYaRetiro,
                'dias_desde_retiro' => $diasDesdeRetiro,
            ];
        });

        return response()->json($personas);
    }

    /**
     * Autocompletado de organizaciones para el formulario de carga
     * de mercaderías (usado por el buscador cuando tipo = organizacion).
     */
    public function buscarOrganizaciones(Request $request)
    {
        $term = trim($request->texto);

        if (empty($term) || strlen($term) < 2) {
            return response()->json([]);
        }

        $organizaciones = Organizacion::where('activo', true)
            ->where(function ($query) use ($term) {
                $query->where('nombre', 'LIKE', "%{$term}%")
                    ->orWhere('cuit_dni', 'LIKE', "%{$term}%");
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

    public function readonlyIndex(Request $request)
    {
        $query = Mercaderia::with(['familia', 'organizacion', 'usuario']);

        $this->applyFilters($query, $request);

        $mercaderias = $query
            ->orderByDesc('fecha_entrega')
            ->orderByDesc('id')
            ->paginate(20);

        $readonly = true;

        return view(
            'frontend.recepcion.mercaderias.index',
            [
                'mercaderias' => $mercaderias,
                'readonly' => $readonly,
                'tipoFiltro' => $request->input('tipo_filtro'),
                'mes' => $request->input('mes'),
                'anio' => $request->input('anio'),
            ]
        );
    }

    public function show($id)
    {
        $mercaderia = Mercaderia::with(['persona', 'familia', 'organizacion', 'usuario'])->findOrFail($id);

        return view('frontend.recepcion.mercaderias.show', compact('mercaderia'));
    }

    public function edit($id)
    {
        $mercaderia = Mercaderia::findOrFail($id);

        return view('frontend.recepcion.mercaderias.edit', compact('mercaderia'));
    }

    public function update(Request $request, $id)
    {
        $mercaderia = Mercaderia::findOrFail($id);

        $request->validate([
            'apellido'      => 'required',
            'nombre'        => 'required',
            'fecha_entrega' => 'required|date',
        ]);

        $familiaId = null;

        if ($request->persona_id) {
            $persona = Persona::find($request->persona_id);
            if ($persona && $persona->familia_id) {
                $familiaId = $persona->familia_id;
            }
        }

        if ($familiaId) {
            $fechaEntrega = \Carbon\Carbon::parse($request->fecha_entrega);

            $ultimoRetiro = Mercaderia::where('familia_id', $familiaId)
                ->where('id', '!=', $id)
                ->orderByDesc('fecha_entrega')
                ->value('fecha_entrega');

            if ($ultimoRetiro) {
                $diasTranscurridos = \Carbon\Carbon::parse($ultimoRetiro)
                    ->diffInDays($fechaEntrega, false);

                if ($diasTranscurridos < 30) {
                    $diasRestantes = 30 - (int) $diasTranscurridos;
                    $proximaFecha  = \Carbon\Carbon::parse($ultimoRetiro)
                        ->addDays(30)
                        ->locale('es')
                        ->isoFormat('D [de] MMMM [de] YYYY');

                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            "Esta familia retiró mercadería hace {$diasTranscurridos} día(s). " .
                            "Podrá retirar nuevamente el {$proximaFecha} " .
                            "({$diasRestantes} día(s) restante(s))."
                        );
                }
            }
        }

        $mercaderia->update([
            'persona_id'    => $request->persona_id ?: null,
            'familia_id'    => $familiaId,
            'dni'           => $request->dni,
            'apellido'      => $request->apellido,
            'nombre'        => $request->nombre,
            'fecha_entrega' => $request->fecha_entrega,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('recepcion.mercaderias.index')
            ->with('success', 'Entrega actualizada correctamente.');
    }
}
