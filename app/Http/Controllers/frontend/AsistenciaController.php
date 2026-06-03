<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Persona;
use App\Models\Sede;
use App\Models\ProgramasAsistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Listado del día (o de la fecha seleccionada) con checkboxes.
     */
    public function index(Request $request)
    {
        // Fecha: hoy por defecto, o la que viene por parámetro
        $fecha = $request->input('fecha')
            ? Carbon::parse($request->input('fecha'))->toDateString()
            : Carbon::today()->toDateString();

        $sedeId     = $request->input('sede_id');
        $programaId = $request->input('programa_id');

        $query = Persona::query()
            ->where('estado', 'aprobado')
            ->select('personas.*');

        if ($sedeId) {
            $query->where('personas.sede_origen_id', $sedeId);
        }

        if ($programaId) {
            $query->whereHas('programas', function ($q) use ($programaId) {
                $q->where('programa_id', $programaId)->where('activo', 1);
            });
        }

        $personas = $query->orderBy('apellido')->orderBy('nombre')->get();

        $personaIds = $personas->pluck('id');

        // Traemos asistencias de la fecha seleccionada incluyendo observaciones
        $asistenciasDia = Asistencia::whereIn('persona_id', $personaIds)
            ->where('fecha', $fecha)
            ->get()
            ->keyBy('persona_id'); // [persona_id => Asistencia]

        $sedes     = Sede::where('activa', 1)->orderBy('nombre')->get();
        $programas = ProgramasAsistencia::orderBy('nombre')->get();

        $esHoy = $fecha === Carbon::today()->toDateString();

        return view('frontend.asistencia.index', compact(
            'personas',
            'asistenciasDia',
            'fecha',
            'esHoy',
            'sedes',
            'programas',
            'sedeId',
            'programaId'
        ));
    }

    /**
     * Guarda la asistencia completa de una fecha (submit masivo).
     */
    public function guardar(Request $request)
    {
        $fecha = $request->input('fecha', Carbon::today()->toDateString());

        $presentesIds  = $request->input('presentes', []);
        $todosIds      = $request->input('todos_ids', []);
        $observaciones = $request->input('observaciones', []); // [persona_id => texto]

        if (empty($todosIds)) {
            return back()->with('warning', 'No hay personas para registrar.');
        }

        DB::transaction(function () use ($todosIds, $presentesIds, $observaciones, $fecha) {
            foreach ($todosIds as $personaId) {
                $presente      = in_array($personaId, $presentesIds);
                $obs           = $observaciones[$personaId] ?? null;

                Asistencia::updateOrCreate(
                    ['persona_id' => $personaId, 'fecha' => $fecha],
                    [
                        'presente'       => $presente,
                        'observaciones'  => $presente ? $obs : null,
                        'registrado_por' => auth()->id(),
                    ]
                );
            }
        });

        $total    = count($todosIds);
        $presentes = count($presentesIds);

        return back()->with('success', "Asistencia guardada: {$presentes} presentes de {$total} personas.");
    }

    /**
     * Toggle AJAX — guarda presente + observación de una persona.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'persona_id'    => 'required|exists:personas,id',
            'presente'      => 'required|boolean',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $hoy = Carbon::today()->toDateString();

        $asistencia = Asistencia::updateOrCreate(
            ['persona_id' => $request->persona_id, 'fecha' => $hoy],
            [
                'presente'       => $request->presente,
                'observaciones'  => $request->presente ? $request->observaciones : null,
                'registrado_por' => auth()->id(),
            ]
        );

        return response()->json(['ok' => true, 'presente' => $asistencia->presente]);
    }

    /**
     * Historial de asistencias de una persona.
     */
    public function historial(Request $request, Persona $persona)
    {
        $mes  = $request->input('mes',  Carbon::today()->month);
        $anio = $request->input('anio', Carbon::today()->year);

        // Rango del mes seleccionado
        $inicio = Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $fin    = $inicio->copy()->endOfMonth();

        $asistencias = Asistencia::where('persona_id', $persona->id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->orderBy('fecha')
            ->get()
            ->keyBy(fn($a) => $a->fecha->toDateString());

        // Días hábiles del mes (lunes a viernes) para el cálculo de %
        $diasDelMes   = [];
        $cursor       = $inicio->copy();
        $hoyStr       = Carbon::today()->toDateString();

        while ($cursor->lte($fin)) {
            $diasDelMes[] = $cursor->copy();
            $cursor->addDay();
        }

        // Solo días hasta hoy para el % real
        $diasHastahoy = array_filter($diasDelMes, fn($d) => $d->toDateString() <= $hoyStr);
        $totalDias    = count($diasHastahoy);
        $presentes    = $asistencias->where('presente', true)->count();
        $porcentaje   = $totalDias > 0 ? round(($presentes / $totalDias) * 100) : 0;

        // Meses disponibles para el selector (últimos 12)
        $mesesDisponibles = [];
        for ($i = 0; $i < 12; $i++) {
            $m = Carbon::today()->subMonths($i);
            $mesesDisponibles[] = ['mes' => $m->month, 'anio' => $m->year, 'label' => ucfirst($m->translatedFormat('F Y'))];
        }

        return view('frontend.asistencia.historial', compact(
            'persona',
            'asistencias',
            'diasDelMes',
            'porcentaje',
            'presentes',
            'totalDias',
            'mes',
            'anio',
            'mesesDisponibles'
        ));
    }
}
