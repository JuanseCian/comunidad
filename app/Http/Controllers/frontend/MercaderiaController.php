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
        $tipoFiltro = $request->tipo_filtro;
        $mes = $request->mes;
        $anio = $request->anio;

        $query = Mercaderia::with([
            'persona',
            'familia',
            'usuario'
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%")
                ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        // FILTRO POR MES
        if ($tipoFiltro === 'mes') {

            $query->whereMonth(
                'fecha_entrega',
                $mes ?: now()->month
            );

            $query->whereYear(
                'fecha_entrega',
                $anio ?: now()->year
            );
        }

        // FILTRO POR SEMANA
        if ($tipoFiltro === 'semana') {

            $inicioSemana = now()->startOfWeek();
            $finSemana = now()->endOfWeek();

            $query->whereBetween(
                'fecha_entrega',
                [$inicioSemana, $finSemana]
            );
        }

        // FILTRO POR AÑO
        if ($tipoFiltro === 'anio') {

            $query->whereYear(
                'fecha_entrega',
                $anio ?: now()->year
            );
        }

        $mercaderias = $query
            ->orderByDesc('fecha_entrega')
            ->paginate(15); 

        return view(
            'frontend.recepcion.mercaderias.index',
            compact(
                'mercaderias',
                'tipoFiltro',
                'mes',
                'anio'
            )
        );
    }

    public function imprimir(Request $request)
    {
        $query = Mercaderia::query();

        if ($request->tipo_filtro == 'mes') {

            $query->whereMonth(
                'fecha_entrega',
                $request->mes
            );

            $query->whereYear(
                'fecha_entrega',
                $request->anio
            );
        }

        if ($request->tipo_filtro == 'anio') {

            $query->whereYear(
                'fecha_entrega',
                $request->anio
            );
        }

        $mercaderias = $query
            ->orderBy('apellido')
            ->get();

        return view(
            'frontend.recepcion.mercaderias.imprimir',
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

    public function show($id)
    {
        $mercaderia = Mercaderia::with(['persona', 'familia', 'usuario'])->findOrFail($id);

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
