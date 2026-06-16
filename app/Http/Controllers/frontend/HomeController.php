<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\ProgramasAsistencia;


class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->rol_id == 6) {
            return redirect()->route('recepcion.dashboard');
        }

        $solicitudesPendientes = Persona::where('estado', 'pendiente')->count();

        $personas = Persona::where('estado', 'aprobado')
            ->with([
                'personaPrograma' => function ($q) {
                    $q->whereNull('fecha_fin')->with('programa');
                }
            ])->get();

        $programas = ProgramasAsistencia::all();

        $alertas = [];

        foreach ($personas as $persona) {
            $this->evaluarProgramasPorEdad($persona);

            $alerta = $persona->alertaPrograma();

            if ($alerta) {
                $alertas[] = [
                    'persona'   => $persona,
                    'mensaje'   => $alerta['mensaje'],
                    'siguiente' => $alerta['siguiente']
                ];
            }
        }

        return view('frontend.home.home', compact(
            'alertas',
            'solicitudesPendientes',
            'programas'
        ));
    }

    private function evaluarProgramasPorEdad(Persona $persona): void
    {
        if (!$persona->fecha_nacimiento) return;

        $edad = $persona->edad;

        foreach ($persona->personaPrograma as $pp) {
            if (!$pp->programa || $pp->fecha_fin) continue;

            $nombre = strtolower($pp->programa->nombre);
            $rol    = $pp->rol;

            if (str_contains($nombre, 'guarderia') && $edad >= 6) {
                $pp->update(['fecha_fin' => now()]);
            } elseif (str_contains($nombre, 'udi') && $edad >= 12) {
                $pp->update(['fecha_fin' => now()]);
            } elseif (str_contains($nombre, 'envion')) {
                if ($rol == 'destinatario' && $edad >= 21) $pp->update(['fecha_fin' => now()]);
                if ($rol == 'tutor' && $edad >= 25) $pp->update(['fecha_fin' => now()]);
            }
        }
    }
}