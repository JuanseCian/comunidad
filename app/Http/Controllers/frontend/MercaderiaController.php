<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mercaderia;
use App\Models\Persona;

class MercaderiaController extends Controller
{
    public function index()
    {
        $mercaderias = Mercaderia::with([
                'persona',
                'familia',
                'usuario'
            ])
            ->latest()
            ->get();

        return view(
            'frontend.recepcion.mercaderias.index',
            compact('mercaderias')
        );
    }

    public function create()
    {
        return view(
            'frontend.recepcion.mercaderias.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'apellido' => 'required',
            'nombre' => 'required',
            'fecha_entrega' => 'required|date',
        ]);

        $persona = null;
        if ($request->persona_id) {
            $persona = Persona::find(
                $request->persona_id
            );
        }

        $familiaId = null;
        if ($persona && $persona->familia_id) {
            $familiaId = $persona->familia_id;
        }

        if ($familiaId) {
            $yaRetiro = Mercaderia::where(
                    'familia_id',
                    $familiaId
                )
                ->whereMonth(
                    'fecha_entrega',
                    now()->month
                )
                ->whereYear(
                    'fecha_entrega',
                    now()->year
                )
                ->exists();

            if ($yaRetiro) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Esta familia ya retiró mercadería este mes.'
                    );

            }

        }

        Mercaderia::create([
            'persona_id' => $request->persona_id,
            'familia_id' => $familiaId,
            'user_id' => auth()->id(),
            'dni' => $request->dni,
            'apellido' => $request->apellido,
            'nombre' => $request->nombre,
            'fecha_entrega' => $request->fecha_entrega,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()

            ->route(
                'recepcion.mercaderias.index'
            )

            ->with(
                'success',
                'Entrega registrada correctamente'
            );
    }

    public function buscarPersonas(Request $request)
    {
        $term = trim($request->texto);

        if (!$term || strlen($term) < 2) {

            return response()->json([]);

        }

        $personas = Persona::query()

            ->where(function ($query) use ($term) {

                $query->whereRaw(
                    'CAST(dni AS CHAR) LIKE ?',
                    ["%{$term}%"]
                )

                ->orWhere(
                    'apellido',
                    'LIKE',
                    "%{$term}%"
                )

                ->orWhere(
                    'nombre',
                    'LIKE',
                    "%{$term}%"
                );

            })

            ->select([
                'id',
                'nombre',
                'apellido',
                'dni',
                'familia_id'
            ])

            ->limit(8)

            ->get();

        return response()->json(
            $personas
        );
    }
}