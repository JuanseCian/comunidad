<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonaBeneficio;
use App\Models\PlanMasVidaFicha;
use App\Models\PlanMasVidaIntegrante;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanMasVidaController extends Controller
{
    public function create($personaBeneficioId)
    {
        $personaBeneficio = PersonaBeneficio::with([
            'persona.familia.personas',
            'persona.domicilio.barrio'
        ])->findOrFail($personaBeneficioId);

        return view(
            'frontend.plan_mas_vida.create',
            compact('personaBeneficio')
        );
    }

    public function store(Request $request, $personaBeneficioId)
    {
        $personaBeneficio = PersonaBeneficio::with([
            'persona.familia.personas'
        ])->findOrFail($personaBeneficioId);

        $ficha = PlanMasVidaFicha::create([
            'persona_beneficio_id' => $personaBeneficio->id,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'situacion_vivienda' => $request->situacion_vivienda,
            'familia_numerosa' => $request->familia_numerosa,
            'casos_judiciales' => $request->casos_judiciales,
            'violencia_familiar' => $request->violencia_familiar,
            'desnutricion' => $request->desnutricion,
            'situacion_salud' => $request->situacion_salud,
            'situacion_laboral' => $request->situacion_laboral,
            'trabajador_social' => $request->trabajador_social,
        ]);

        foreach ($request->integrantes as $integrante) {
            PlanMasVidaIntegrante::create([
                'ficha_id' => $ficha->id,
                'apellido_nombre' => $integrante['apellido_nombre'] ?? null,
                'vinculo' => $integrante['vinculo'] ?? null,
                'fecha_nacimiento' => $integrante['fecha_nacimiento'] ?? null,
                'cuil_dni' => $integrante['cuil_dni'] ?? null,
                'vacunas' => isset($integrante['vacunas']),
                'embarazo' => isset($integrante['embarazo']),
                'discapacidad' => $integrante['discapacidad'] ?? null,
                'enfermedades' => $integrante['enfermedades'] ?? null,
                'asiste' => isset($integrante['asiste']),
                'nivel_alcanzado' => $integrante['nivel_alcanzado'] ?? null,
                'escuela' => $integrante['escuela'] ?? null,
                'auh' => isset($integrante['auh']),
            ]);
        }

        return redirect()
            ->route('personas.show', $personaBeneficio->persona_id)
            ->with('success', 'Ficha Plan Más Vida registrada correctamente.');
    }

    public function show($id)
    {
        $ficha = PlanMasVidaFicha::with([
            'integrantes',
            'beneficio.persona'
        ])->findOrFail($id);

        return view(
            'frontend.plan_mas_vida.show',
            compact('ficha')
        );
    }

    public function edit($id)
    {
        $ficha = PlanMasVidaFicha::with([
            'integrantes',
            'beneficio.persona'
        ])->findOrFail($id);

        return view(
            'frontend.plan_mas_vida.edit',
            compact('ficha')
        );
    }

    public function update(Request $request, $id)
    {
        $ficha = PlanMasVidaFicha::findOrFail($id);

        $ficha->update([
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
            'situacion_vivienda' => $request->situacion_vivienda,
            'familia_numerosa' => $request->familia_numerosa,
            'casos_judiciales' => $request->casos_judiciales,
            'violencia_familiar' => $request->violencia_familiar,
            'desnutricion' => $request->desnutricion,
            'situacion_salud' => $request->situacion_salud,
            'situacion_laboral' => $request->situacion_laboral,
            'trabajador_social' => $request->trabajador_social,
        ]);

        foreach ($request->integrantes as $idIntegrante => $datos) {

            PlanMasVidaIntegrante::where('id', $idIntegrante)
                ->update([
                    'vacunas' => isset($datos['vacunas']),
                    'embarazo' => isset($datos['embarazo']),
                    'discapacidad' => $datos['discapacidad'],
                    'enfermedades' => $datos['enfermedades'],
                    'asiste' => isset($datos['asiste']),
                    'nivel_alcanzado' => $datos['nivel_alcanzado'],
                    'escuela' => $datos['escuela'],
                    'auh' => isset($datos['auh']),
                ]);
        }

        return redirect()
            ->route(
                'personas.show',
                $ficha->beneficio->persona_id
            )
            ->with(
                'success',
                'Ficha actualizada correctamente.'
            );
    }

    public function pdf($id)
    {
        $ficha = PlanMasVidaFicha::with([
            'integrantes',
            'beneficio.persona.familia',
            'beneficio.persona.domicilio.barrio',
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'frontend.plan_mas_vida.pdf',
            compact('ficha')
        );

        $nombre = 'PlanMasVida_'.$ficha->beneficio->persona->dni.'.pdf';

        //return $pdf->download($nombre);

        // Para abrir en navegador:
        return $pdf->stream($nombre);
    }
}
