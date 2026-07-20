<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sepelio;
use App\Models\Persona;

class SepelioController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $sepelios = Sepelio::with(['persona', 'familia', 'usuario'])
            ->when($search, function ($query) use ($search) {
                return $query->where('apellido', 'like', "%{$search}%")
                    ->orWhere('nombre', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhere('fallecido_nombre', 'like', "%{$search}%")
                    ->orWhere('fallecido_dni', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('frontend.recepcion.sepelios.index', compact('sepelios'));
    }

    public function create()
    {
        return view('frontend.recepcion.sepelios.create');
    }

    public function store(Request $request)
    {
        $familiaId = null;

        if ($request->filled('persona_id')) {
            $persona = Persona::find($request->persona_id);
            if ($persona) {
                $familiaId = $persona->familia_id;
            }
        }

        // Validación estricta y limpia
        $request->validate([
            'apellido'           => 'required|string|max:100',
            'nombre'             => 'required|string|max:100',
            'fallecido_nombre'   => 'required|string|max:150',
            'tipo_sepelio'       => 'required|in:municipal,particular',
            'categoria_servicio' => 'required|in:angelito,normal,vaca,extra_vaca',
            'fecha_solicitud'    => 'nullable|date',
            'fecha_fallecimiento'=> 'nullable|date',
            'costo'              => 'nullable|numeric|min:0',
        ]);

        // Lógica de cremación: Lo inyectamos en las observaciones para no romper el ENUM de la BD
        $observacionesFinales = $request->observaciones;
        if ($request->boolean('es_cremacion')) {
            $prefijo = "[SERVICIO CON CREMACIÓN] ";
            $observacionesFinales = $observacionesFinales ? $prefijo . $observacionesFinales : $prefijo;
        }

        Sepelio::create([
            'persona_id'           => $request->persona_id,
            'familia_id'           => $familiaId,
            'user_id'              => auth()->id(),
            'dni'                  => $request->dni,
            'apellido'             => $request->apellido,
            'nombre'               => $request->nombre,
            'telefono_responsable' => $request->telefono_responsable,
            'fallecido_nombre'     => $request->fallecido_nombre,
            'fallecido_dni'        => $request->fallecido_dni,
            'fecha_fallecimiento'  => $request->fecha_fallecimiento,
            'solicitante'          => $request->solicitante,
            'domicilio'            => $request->domicilio,
            'barrio'               => $request->barrio,
            'caracter'             => $request->caracter,
            'tipo_sepelio'         => $request->tipo_sepelio,
            'categoria_servicio'   => $request->categoria_servicio,
            // Si es cremación, el mantenimiento va en 0 automáticamente
            'mantenimiento'        => $request->boolean('es_cremacion') ? 0 : $request->boolean('mantenimiento'),
            'fecha_solicitud'      => $request->fecha_solicitud ?? now()->format('Y-m-d'),
            'costo'                => $request->costo,
            'observaciones'        => $observacionesFinales,
        ]);

        return redirect()
            ->route('recepcion.sepelios.index')
            ->with('success', 'Sepelio registrado correctamente.');
    }

    public function buscarPersonas(Request $request)
    {
        $term = trim($request->texto);

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $personas = Persona::query()
            ->where(function ($q) use ($term) {
                $q->where('dni', 'like', "%{$term}%")
                  ->orWhere('apellido', 'like', "%{$term}%")
                  ->orWhere('nombre', 'like', "%{$term}%");
            })
            ->whereNull('deleted_at')
            ->select(['id', 'nombre', 'apellido', 'dni', 'telefono', 'familia_id'])
            ->limit(8)
            ->get();

        return response()->json($personas);
    }
}