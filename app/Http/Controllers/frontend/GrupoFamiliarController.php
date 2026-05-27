<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\GrupoFamiliar;
use App\Models\Persona;
use App\Models\Sexo;
use App\Models\TipoDocumento;
use App\Models\EstadoCivil;
use App\Models\Discapacidad;
use App\Models\Enfermedad;
use App\Models\Cobertura;
use App\Models\SituacionOcupacional;
use App\Models\CondicionInactividad;
use App\Models\CategoriaOcupacional;
use App\Models\NucleoConviviente;
use App\Models\PersonaNucleo;
use Illuminate\Http\Request;


class GrupoFamiliarController extends Controller
{

    public function create(Persona $persona)
    {
        $catalogos = [
            'sexos'                   => Sexo::orderBy('nombre')->get(),
            'tipos_documento'         => TipoDocumento::orderBy('nombre')->get(),
            'estados_civiles'         => EstadoCivil::orderBy('nombre')->get(),
            'discapacidades'          => Discapacidad::orderBy('nombre')->get(),
            'enfermedades'            => Enfermedad::orderBy('nombre')->get(),
            'coberturas'              => Cobertura::orderBy('nombre')->get(),
            'situaciones_ocupacional' => SituacionOcupacional::orderBy('nombre')->get(),
            'condiciones_inactividad' => CondicionInactividad::orderBy('nombre')->get(),
            'categorias_ocupacional'  => CategoriaOcupacional::orderBy('nombre')->get(),
        ];

        return view('frontend.grupofamiliar.create', compact('persona', 'catalogos'));
    }


    public function store(Request $request, Persona $persona)
    {
        $validated = $request->validate([
            'nombre'                    => 'required|string|max:150',
            'documento_id'              => 'nullable|exists:tipo_documento,id',
            'numero_documento'          => 'nullable|string|max:20',
            'sexo_id'                   => 'nullable|exists:sexo,id',
            'fecha_nacimiento'          => 'nullable|date|before:today',
            'relacion_titular'          => 'nullable|string|max:50',
            'estado_civil_id'           => 'nullable|exists:estado_civil,id',
            'discapacidad_permanente'   => 'nullable|boolean',
            'discapacidad_id'           => 'nullable|exists:discapacidad,id',
            'discapacidad_tratamiento'  => 'nullable|boolean',
            'caratula'                  => 'nullable|string|max:150',
            'enfermedad_id'             => 'nullable|exists:enfermedades,id',
            'enfermedad_tratamiento'    => 'nullable|boolean',
            'embarazo'                  => 'nullable|boolean',
            'control_embarazo'          => 'nullable|boolean',
            'esquema_vacunacion'        => 'nullable|boolean',
            'cobertura_id'              => 'nullable|exists:cobertura,id',
            'situacion_ocupacional_id'  => 'nullable|exists:situacion_ocupacional,id',
            'condicion_inactividad_id'  => 'nullable|exists:condicion_inactividad,id',
            'categoria_ocupacional_id'  => 'nullable|exists:categoria_ocupacional,id',
            'ingresos'                  => 'nullable|numeric|min:0',
            'es_conviviente'            => 'nullable|boolean',
        ]);

        $validated['persona_id']  = $persona->id;
        $validated['familia_id']  = $persona->familia_id;
        $validated['created_by']  = auth()->id();

        foreach (['discapacidad_permanente','discapacidad_tratamiento','enfermedad_tratamiento',
                  'embarazo','control_embarazo','esquema_vacunacion'] as $campo) {
            $validated[$campo] = $request->boolean($campo);
        }

        $esConviviente = $request->boolean('es_conviviente');
        unset($validated['es_conviviente']);

        $integrante = GrupoFamiliar::create($validated);

        // Si el integrante convive con el titular, vincularlo al núcleo conviviente
        // de ESA persona específica (no de cualquier titular de la familia).
        // Si no existe, se crea uno nuevo asociado al domicilio del titular.
        if ($esConviviente && $persona->familia_id) {
            $nucleo = NucleoConviviente::firstOrCreate(
                [
                    'familia_id' => $persona->familia_id,
                    'activo'     => true,
                    'domicilio_id' => $persona->domicilio_id,
                ],
                [
                    'descripcion' => 'Núcleo principal',
                    'created_by'  => auth()->id(),
                ]
            );

            PersonaNucleo::firstOrCreate([
                'nucleo_id'         => $nucleo->id,
                'grupo_familiar_id' => $integrante->id,
            ]);

            // Vincular también a la persona titular al mismo núcleo (persona_id)
            PersonaNucleo::firstOrCreate([
                'nucleo_id'  => $nucleo->id,
                'persona_id' => $persona->id,
            ]);
        }

        return redirect()
            ->route('personas.show', $persona)
            ->with('success', 'Integrante agregado al grupo familiar correctamente.');
    }
}