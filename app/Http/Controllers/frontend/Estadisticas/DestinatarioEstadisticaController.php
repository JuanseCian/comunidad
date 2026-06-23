<?php

namespace App\Http\Controllers\frontend\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\PersonaPrograma;
use App\Models\PersonaBeneficio;
use Illuminate\Http\Request;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;
use App\Exports\DestinatariosExport;
use Maatwebsite\Excel\Facades\Excel;

class DestinatarioEstadisticaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PRINCIPAL
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $envion = PersonaPrograma::whereHas('programa', function ($q) {
            $q->where('nombre', 'like', '%envion%');
        })->count();

        $udi = PersonaPrograma::whereHas('programa', function ($q) {
            $q->where('nombre', 'like', '%udi%');
        })->count();

        $guarderia = PersonaPrograma::whereHas('programa', function ($q) {
            $q->where('nombre', 'like', '%guarderia%');
        })->count();

        $multiespacio = PersonaPrograma::whereHas('programa', function ($q) {
            $q->where('nombre', 'like', '%multiespacio%');
        })->count();

        return view(
            'frontend.estadisticas.destinatarios.index',
            compact(
                'envion',
                'udi',
                'guarderia',
                'multiespacio'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENVION
    |--------------------------------------------------------------------------
    */

    public function envion(Request $request)
    {
        return $this->estadisticasPrograma('envion', $request);
    }

    /*
    |--------------------------------------------------------------------------
    | UDI
    |--------------------------------------------------------------------------
    */

    public function udi(Request $request)
    {
        return $this->estadisticasPrograma('udi', $request);
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDERIA
    |--------------------------------------------------------------------------
    */

    public function guarderia(Request $request)
    {
        return $this->estadisticasPrograma('guarderia', $request);
    }

    /*
    |--------------------------------------------------------------------------
    | MULTIESPACIO
    |--------------------------------------------------------------------------
    */

    public function multiespacio(Request $request)
    {
        return $this->estadisticasPrograma('multiespacio', $request);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODO CENTRAL
    |--------------------------------------------------------------------------
    */

    private function estadisticasPrograma($nombrePrograma, Request $request)
    {
        $participantes = PersonaPrograma::query()
            ->whereHas('programa', function ($q) use ($nombrePrograma) {
                $q->where(
                    'nombre',
                    'like',
                    "%{$nombrePrograma}%"
                );
            });
        if ($request->filled('sede_id')) {

            $participantes->where(
                'persona_programa.sede_id',
                $request->sede_id
            );
        }
        
        if ($request->filled('anio')) {

            $participantes->whereYear(
                'fecha_inicio',
                $request->anio
            );
        }

        if ($request->filled('mes')) {

            $participantes->whereMonth(
                'fecha_inicio',
                $request->mes
            );
        }

        $total = (clone $participantes)->count();

        $activos = (clone $participantes)
            ->where('activo', 1)
            ->count();

        $finalizados = (clone $participantes)
            ->where('activo', 0)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | SEDES
        |--------------------------------------------------------------------------
        */

        $sedes = (clone $participantes)
            ->join(
                'sedes',
                'persona_programa.sede_id',
                '=',
                'sedes.id'
            )
            ->select(
                'sedes.nombre',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('sedes.nombre')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | BARRIOS
        |--------------------------------------------------------------------------
        */

        $barrios = (clone $participantes)
            ->join(
                'personas',
                'persona_programa.persona_id',
                '=',
                'personas.id'
            )
            ->join(
                'domicilio',
                'personas.domicilio_id',
                '=',
                'domicilio.id'
            )
            ->join(
                'barrio',
                'domicilio.barrio_id',
                '=',
                'barrio.id'
            )
            ->select(
                'barrio.nombre',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('domicilio.barrio_id')
            ->groupBy(
                'barrio.id',
                'barrio.nombre'
            )
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | BENEFICIOS
        |--------------------------------------------------------------------------
        */

        $beneficios = PersonaBeneficio::query()
            ->join(
                'beneficios',
                'persona_beneficio.beneficio_id',
                '=',
                'beneficios.id'
            )
            ->join(
                'personas',
                'persona_beneficio.persona_id',
                '=',
                'personas.id'
            )
            ->join(
                'persona_programa',
                'personas.id',
                '=',
                'persona_programa.persona_id'
            )
            ->join(
                'programas_asistencia',
                'persona_programa.programa_id',
                '=',
                'programas_asistencia.id'
            )
            ->where(
                'programas_asistencia.nombre',
                'like',
                "%{$nombrePrograma}%"
            )
            ->where(
                'persona_beneficio.activo',
                1
            )
            ->select(
                'beneficios.nombre',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('beneficios.nombre')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | EDADES
        |--------------------------------------------------------------------------
        */

        $edades = (clone $participantes)
            ->join(
                'personas',
                'persona_programa.persona_id',
                '=',
                'personas.id'
            )
            ->select(
                DB::raw("
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) <= 5
                            THEN '0-5'

                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) <= 12
                            THEN '6-12'

                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) <= 18
                            THEN '13-18'

                        WHEN TIMESTAMPDIFF(YEAR, personas.fecha_nacimiento, CURDATE()) <= 25
                            THEN '19-25'

                        ELSE '26+'
                    END as rango
                "),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('rango')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ALTAS POR MES
        |--------------------------------------------------------------------------
        */

        $ingresosMensuales = (clone $participantes)
            ->select(
                DB::raw("DATE_FORMAT(fecha_inicio,'%Y-%m') as periodo"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        return view(
            'frontend.estadisticas.destinatarios.programa',
            [
                'programa' => ucfirst($nombrePrograma),
                'total' => $total,
                'activos' => $activos,
                'finalizados' => $finalizados,
                'sedes' => $sedes,
                'barrios' => $barrios,
                'beneficios' => $beneficios,
                'edades' => $edades,
                'ingresosMensuales' => $ingresosMensuales,
                'listaSedes' => Sede::orderBy('nombre')->get(),
            ]
        );
    }

    public function exportExcel($programa, Request $request)
    {
        return Excel::download(
            new DestinatariosExport(
                $programa,
                $request->get('sede_id'),
                $request->get('anio'),
                $request->get('mes')
            ),
            'estadisticas_destinatarios_' . strtolower($programa) . '.xlsx'
        );
    }
}