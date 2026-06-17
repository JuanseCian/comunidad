<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?string $fechaDesde,
        protected ?string $fechaHasta
    ) {
    }

    public function collection()
    {
        $ingresoQuery = DB::table('ingresos');
        $atencionQuery = DB::table('atenciones');
        $beneficioQuery = DB::table('persona_beneficio');
        $mercaderiaQuery = DB::table('mercaderias');
        $programaQuery = DB::table('persona_programa');

        if ($this->fechaDesde) {
            $ingresoQuery->whereDate('fecha_ingreso', '>=', $this->fechaDesde);
            $atencionQuery->whereDate('fecha_atencion', '>=', $this->fechaDesde);
            $beneficioQuery->whereDate('created_at', '>=', $this->fechaDesde);
            $mercaderiaQuery->whereDate('fecha_entrega', '>=', $this->fechaDesde);
            $programaQuery->whereDate('fecha_inicio', '>=', $this->fechaDesde);
        }

        if ($this->fechaHasta) {
            $ingresoQuery->whereDate('fecha_ingreso', '<=', $this->fechaHasta);
            $atencionQuery->whereDate('fecha_atencion', '<=', $this->fechaHasta);
            $beneficioQuery->whereDate('created_at', '<=', $this->fechaHasta);
            $mercaderiaQuery->whereDate('fecha_entrega', '<=', $this->fechaHasta);
            $programaQuery->whereDate('fecha_inicio', '<=', $this->fechaHasta);
        }

        $rows = [
            ['Métrica', 'Valor'],
            ['Total Personas', DB::table('personas')->count()],
            ['Total Ingresos', $ingresoQuery->count()],
            ['Total Familias', DB::table('familias')->count()],
            ['Total Atenciones', $atencionQuery->count()],
            ['Total Beneficios', $beneficioQuery->count()],
            ['Total Mercaderías', $mercaderiaQuery->count()],
            ['Programas Activos', (clone $programaQuery)->where('activo', 1)->count()],
            ['Personas con Programa', (clone $programaQuery)->where('activo', 1)->distinct('persona_id')->count('persona_id')],
            ['Beneficios Activos', (clone $beneficioQuery)->where('activo', 1)->count()],
            ['Personas con Beneficio', (clone $beneficioQuery)->where('activo', 1)->distinct('persona_id')->count('persona_id')],
        ];

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'Métrica',
            'Valor'
        ];
    }
}
