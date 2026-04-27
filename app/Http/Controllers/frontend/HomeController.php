<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Persona;

class HomeController extends Controller
{
    public function index()
    {
        $personas = Persona::with('personaPrograma.programa')->get();

        $alertas = [];

        foreach ($personas as $persona) {

            // 🔥 actualiza automáticamente
            $persona->actualizarProgramasPorEdad();

            $alerta = $persona->alertaPrograma();

            if ($alerta) {
                $alertas[] = [
                    'persona'   => $persona,
                    'mensaje'   => $alerta['mensaje'],
                    'siguiente' => $alerta['siguiente']
                ];
            }
        }

        return view('frontend.home', compact('alertas'));
    }

}