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

    public function seleccionar()
    {
        $programas = ProgramasAsistencia::orderBy('nombre')->get();

        $sedes = Sede::where('activa', 1)
            ->orderBy('nombre')
            ->get();

        return view(
            'frontend.asistencia.seleccionar',
            compact('programas', 'sedes')
        );
    }   

    public function index(Request $request)
    {
        if (!$request->filled('programa_id')) {
            return redirect()->route('asistencia.seleccionar');
        }

        $fecha = $request->input('fecha')
            ? Carbon::parse($request->input('fecha'))->toDateString()
            : Carbon::today()->toDateString();

        $sedeId     = $request->input('sede_id');
        $programaId = $request->input('programa_id');

        $query = Persona::query()
            ->with([
                'programas',
                'personaPrograma.sede'
            ])
            ->where('estado', 'aprobado');

        if ($programaId) {

            $query->whereHas('personaPrograma', function ($q) use ($programaId, $sedeId) {

                $q->where('programa_id', $programaId)
                ->where('activo', 1);

                if ($sedeId) {
                    $q->where('sede_id', $sedeId);
                }
            });
        }

        $personas = $query
        ->with([
            'personaPrograma.sede',
            'programas'
        ])
        ->orderBy('apellido')
        ->orderBy('nombre')
        ->get();
        

        $personaIds = $personas->pluck('id');

        $asistenciasDia = Asistencia::whereIn('persona_id', $personaIds)
            ->where('fecha', $fecha)
            ->get()
            ->keyBy('persona_id');

        $sedes = Sede::whereIn('id', function ($query) use ($programaId) {

        $query->select('sede_id')
                ->from('persona_programa')
                ->where('activo', 1);

            if ($programaId) {
                $query->where('programa_id', $programaId);
            }

        })
        ->orderBy('nombre')
        ->get();

        $programas = ProgramasAsistencia::orderBy('nombre')
            ->get();

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

    public function guardar(Request $request)
    {
        $fecha = $request->input('fecha', Carbon::today()->toDateString());

        $presentesIds  = $request->input('presentes', []);
        $todosIds      = $request->input('todos_ids', []);
        $observaciones = $request->input('observaciones', []); 

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

    public function historial(Request $request, Persona $persona)
    {
        $mes  = $request->input('mes',  Carbon::today()->month);
        $anio = $request->input('anio', Carbon::today()->year);

        $inicio = Carbon::createFromDate($anio, $mes, 1)->startOfMonth();
        $fin    = $inicio->copy()->endOfMonth();

        $asistencias = Asistencia::where('persona_id', $persona->id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->orderBy('fecha')
            ->get()
            ->keyBy(fn($a) => $a->fecha->toDateString());

        $diasDelMes   = [];
        $cursor       = $inicio->copy();
        $hoyStr       = Carbon::today()->toDateString();

        while ($cursor->lte($fin)) {
            $diasDelMes[] = $cursor->copy();
            $cursor->addDay();
        }

        $diasHastahoy = array_filter($diasDelMes, fn($d) => $d->toDateString() <= $hoyStr);
        $totalDias    = count($diasHastahoy);
        $presentes    = $asistencias->where('presente', true)->count();
        $porcentaje   = $totalDias > 0 ? round(($presentes / $totalDias) * 100) : 0;

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
