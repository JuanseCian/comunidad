<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BajoPeso;
use App\Models\Familia;
use App\Models\Persona;
use Carbon\Carbon;

class BajoPesoController extends Controller
{
    public function index()
    {
        $beneficiarios = BajoPeso::with([
            'familia',
            'persona',
            'entregas'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'frontend.recepcion.bajo-peso.index',
            compact('beneficiarios')
        );
    }

    public function create()
    {
        $personas = Persona::whereNotNull('fecha_nacimiento')
            ->whereNotIn('id', function ($query) {
                $query->select('persona_id')
                    ->from('bajo_pesos')
                    ->where('activo', 1);
            })
            ->get()
            ->filter(function ($persona) {
                return $persona->edad <= 6;
            })
            ->sortBy('apellido');

        return view(
            'frontend.recepcion.bajo-peso.create',
            compact('personas')
        );
    }

    public function datosPersona($id)
    {
        $persona = Persona::with('familia')
            ->findOrFail($id);

        return response()->json([
            'id' => $persona->id,
            'nombre' => $persona->nombre,
            'apellido' => $persona->apellido,
            'dni' => $persona->dni,
            'edad' => $persona->edad,
            'fecha_nacimiento' => optional($persona->fecha_nacimiento)
                ->format('d/m/Y'),
            'familia_id' => $persona->familia_id,
            'familia_codigo' => optional($persona->familia)->codigo,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required',

            'tutor_nombre' => 'nullable|string|max:255',
            'tutor_dni' => 'nullable|string|max:20',
            'tutor_parentezco' => 'nullable|string|max:255',
            
            'certificado_bajo_peso' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'informe_socioambiental' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',    
        ]);

        $certificado = null;
        $informe = null;

        if ($request->hasFile('certificado_bajo_peso')) {

            \Illuminate\Support\Facades\Storage::makeDirectory(
                'bajo_peso/certificados'
            );

            $certificado = $request
    ->file('certificado_bajo_peso')
    ->store('bajo_peso/certificados', 'public');
        }

        if ($request->hasFile('informe_socioambiental')) {

            \Illuminate\Support\Facades\Storage::makeDirectory(
                'bajo_peso/socioambientales'
            );

            $informe = $request
    ->file('informe_socioambiental')
    ->store('bajo_peso/socioambientales', 'public');
        }

        $persona = Persona::findOrFail(
            $request->persona_id
        );

        $cantidadGrupo = BajoPeso::where('activo', 1)
            ->where('familia_id', $persona->familia_id)
            ->count();

        if ($cantidadGrupo >= 3) {

            return back()
                ->withErrors([
                    'persona_id' =>
                    'Este grupo familiar ya posee 3 menores registrados en Bajo Peso.'
                ])
                ->withInput();
        }

        $beneficiariosActivos = BajoPeso::where(
                'familia_id',
                $persona->familia_id
            )
            ->where('activo', 1)
            ->count();

        if ($beneficiariosActivos >= 3) {

            return back()
                ->withErrors([
                    'persona_id' =>
                    'Este grupo familiar ya posee el máximo de 3 beneficiarios de Bajo Peso.'
                ])
                ->withInput();
        }

        $yaExiste = BajoPeso::where(
                'persona_id',
                $persona->id
            )
            ->where('activo', 1)
            ->exists();

        if ($yaExiste) {

            return back()
                ->withErrors([
                    'persona_id' =>
                    'La persona ya se encuentra registrada en el programa.'
                ])
                ->withInput();
        }
        
        $existe = BajoPeso::where('persona_id', $persona->id)
            ->where('activo', 1)
            ->exists();

        if ($existe) {

            return back()
                ->withErrors([
                    'persona_id' =>
                    'La persona ya se encuentra registrada en el programa Bajo Peso.'
                ])
                ->withInput();
        }

        if ($persona->edad > 6) {

            return back()
                ->withErrors([
                    'persona_id' =>
                    'El beneficiario no puede superar los 6 años.'
                ])
                ->withInput();
        }

        if ($request->persona_id) {

            $persona = Persona::findOrFail(
                $request->persona_id
            );

        } else {

            $familia = Familia::create([
                'codigo' => Familia::generarCodigo()
            ]);

            $persona = Persona::create([
                'familia_id' => $familia->id,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'dni' => $request->dni,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'estado' => 'aprobado'
            ]);
        }
        BajoPeso::create([

            'familia_id' => $persona->familia_id,
            'persona_id' => $persona->id,

            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,

            'certificado_bajo_peso' => $certificado,
            'informe_socioambiental' => $informe,
            
            'tutor_nombre' => $request->tutor_nombre,
            'tutor_dni' => $request->tutor_dni,
            'tutor_parentezco' => $request->tutor_parentezco,

            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('bajo-peso.index')
            ->with('success', 'Beneficiario registrado correctamente.');
    }

    public function buscarMenores(Request $request)
    {
        $term = trim($request->texto ?? '');

        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        $personas = Persona::with('familia')
            ->where(function ($query) use ($term) {

                $query->whereRaw(
                        'CAST(dni AS CHAR) LIKE ?',
                        ["%{$term}%"]
                    )
                    ->orWhere('apellido', 'LIKE', "%{$term}%")
                    ->orWhere('nombre', 'LIKE', "%{$term}%");
            })

            ->whereNotIn('id', function ($query) {
                $query->select('persona_id')
                    ->from('bajo_pesos')
                    ->where('activo', 1);
            })

            ->orderBy('apellido')
            ->orderBy('nombre')
            ->limit(20)
            ->get()

            ->filter(function ($persona) {
                return $persona->fecha_nacimiento
                    && $persona->edad <= 6;
            })

            ->map(function ($persona) {

                return [
                    'id' => $persona->id,
                    'nombre' => $persona->nombre,
                    'apellido' => $persona->apellido,
                    'dni' => $persona->dni,
                    'fecha_nacimiento' => optional($persona->fecha_nacimiento)
                        ? $persona->fecha_nacimiento->format('Y-m-d')
                        : null,
                    'edad' => $persona->edad,
                    'familia_id' => $persona->familia_id,
                    'familia_codigo' => optional($persona->familia)->codigo,
                ];
            })

            ->take(8)
            ->values();

        return response()->json($personas);
    }

    public function show($id)
    {
        $beneficiario = BajoPeso::with([
            'familia',
            'persona',
            'entregas'
        ])->findOrFail($id);

        return view(
            'frontend.recepcion.bajo-peso.show',
            compact('beneficiario')
        );
    }

    public function edit($id)
    {
        $bajoPeso = BajoPeso::findOrFail($id);

        return view(
            'frontend.recepcion.bajo-peso.edit',
            compact('bajoPeso')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'certificado_bajo_peso'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'informe_socioambiental' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $beneficiario = BajoPeso::findOrFail($id);

        // Certificado: subir nuevo si viene, mantener el anterior si no
        $certificado = $beneficiario->certificado_bajo_peso;

        if ($request->hasFile('certificado_bajo_peso')) {

            \Illuminate\Support\Facades\Storage::makeDirectory(
                'bajo_peso/certificados'
            );

            $certificado = $request
    ->file('certificado_bajo_peso')
    ->store('bajo_peso/certificados', 'public');
        }

        // Informe: subir nuevo si viene, mantener el anterior si no
        $informe = $beneficiario->informe_socioambiental;

        if ($request->hasFile('informe_socioambiental')) {

            \Illuminate\Support\Facades\Storage::makeDirectory(
                'bajo_peso/socioambientales'
            );

            $informe = $request
    ->file('informe_socioambiental')
    ->store('bajo_peso/socioambientales', 'public');
        }

        $beneficiario->update([
            'diagnostico'            => $request->diagnostico,
            'tratamiento'            => $request->tratamiento,
            'tutor_nombre'           => $request->tutor_nombre,
            'tutor_dni'              => $request->tutor_dni,
            'tutor_parentezco'       => $request->tutor_parentezco,
            'observaciones'          => $request->observaciones,
            'activo'                 => $request->activo,
            'certificado_bajo_peso'  => $certificado,
            'informe_socioambiental' => $informe,
        ]);

        return redirect()
            ->route('bajo-peso.show', $id)
            ->with('success', 'Registro actualizado.');
    }

    public function destroy($id)
    {
        BajoPeso::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Registro eliminado correctamente.'
        );
    }
}