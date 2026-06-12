<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeneficiosExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?int $beneficioId,
        protected ?string $fechaDesde,
        protected ?string $fechaHasta
    ) {
    }

    public function collection()
    {
        $qBeneficios = DB::table('persona_beneficio')
            ->join('beneficios', 'persona_beneficio.beneficio_id', '=', 'beneficios.id')
            ->join('personas', 'persona_beneficio.persona_id', '=', 'personas.id')
            ->join('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->join('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->selectRaw(
                "beneficios.nombre as item_name,
                personas.apellido,
                personas.nombre,
                persona_beneficio.fecha_otorgamiento as fecha,
                persona_beneficio.monto,
                barrio.nombre as barrio"
            )
            ->when($this->beneficioId, function ($query) {
                $query->where('persona_beneficio.beneficio_id', $this->beneficioId);
            })
            ->when(!$this->beneficioId, function ($query) {
                $query->whereNotIn('persona_beneficio.beneficio_id', [1, 2]);
            })
            ->when($this->fechaDesde, function ($query) {
                $query->whereDate('persona_beneficio.created_at', '>=', $this->fechaDesde);
            })
            ->when($this->fechaHasta, function ($query) {
                $query->whereDate('persona_beneficio.created_at', '<=', $this->fechaHasta);
            });

        $qBajoPeso = DB::table('bajo_pesos')
            ->join('personas', 'bajo_pesos.persona_id', '=', 'personas.id')
            ->join('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->join('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->selectRaw(
                "'Bajo Peso' as item_name,
                personas.apellido,
                personas.nombre,
                bajo_pesos.created_at as fecha,
                NULL as monto,
                barrio.nombre as barrio"
            )
            ->when($this->fechaDesde, function ($query) {
                $query->whereDate('bajo_pesos.created_at', '>=', $this->fechaDesde);
            })
            ->when($this->fechaHasta, function ($query) {
                $query->whereDate('bajo_pesos.created_at', '<=', $this->fechaHasta);
            })
            ->when($this->beneficioId && $this->beneficioId !== 1, function ($query) {
                $query->whereRaw('1 = 0');
            });

        $qMercaderia = DB::table('mercaderias')
            ->join('personas', 'mercaderias.persona_id', '=', 'personas.id')
            ->join('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->join('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->selectRaw(
                "'Mercadería' as item_name,
                personas.apellido,
                personas.nombre,
                mercaderias.created_at as fecha,
                NULL as monto,
                barrio.nombre as barrio"
            )
            ->when($this->fechaDesde, function ($query) {
                $query->whereDate('mercaderias.created_at', '>=', $this->fechaDesde);
            })
            ->when($this->fechaHasta, function ($query) {
                $query->whereDate('mercaderias.created_at', '<=', $this->fechaHasta);
            })
            ->when($this->beneficioId && $this->beneficioId !== 2, function ($query) {
                $query->whereRaw('1 = 0');
            });

        $union = $qBeneficios->unionAll($qBajoPeso)->unionAll($qMercaderia);

        return DB::table(DB::raw("({$union->toSql()}) as unificado"))
            ->mergeBindings($union)
            ->select('item_name', 'apellido', 'nombre', 'fecha', 'monto', 'barrio')
            ->orderBy('fecha', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Motivo',
            'Apellido',
            'Nombre',
            'Fecha',
            'Monto',
            'Barrio'
        ];
    }
}
