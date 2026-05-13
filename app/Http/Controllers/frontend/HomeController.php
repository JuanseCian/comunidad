<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\ProgramasAsistencia;


class HomeController extends Controller
{
    public function index()
    {
        $solicitudesPendientes = Persona::where('estado', 'pendiente')->count();

        $personas = Persona::where('estado', 'aprobado')
            ->with(['personaPrograma' => function($q) {
                $q->whereNull('fecha_fin')->with('programa');
            }])->get();

        $programas = ProgramasAsistencia::all(); 

        $alertas = [];

        foreach ($personas as $persona) {
            $personaController = new PersonaController();
            $personaController->evaluarProgramasPorEdad($persona);
            $alerta = $persona->alertaPrograma();

            if ($alerta) {
                $alertas[] = [
                    'persona'   => $persona,
                    'mensaje'   => $alerta['mensaje'],
                    'siguiente' => $alerta['siguiente']
                ];
            }
        }

        return view('frontend.home.home', compact('alertas', 'solicitudesPendientes', 'programas'));
    }
}