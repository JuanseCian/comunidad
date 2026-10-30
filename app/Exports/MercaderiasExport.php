<?php

namespace App\Exports;

use App\Models\Mercaderia;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MercaderiasExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?string $search = null,
        protected ?string $tipoFiltro = null,
        protected ?int $mes = null,
        protected ?int $anio = null
    ) {
    }

    public function collection()
    {
        $query = Mercaderia::with(['usuario', 'organizacion']);

        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->where('nombre', 'like', "%{$this->search}%")
                    ->orWhere('apellido', 'like', "%{$this->search}%")
                    ->orWhere('dni', 'like', "%{$this->search}%");
            });
        }

        if ($this->tipoFiltro === 'mes' && $this->mes >= 1 && $this->mes <= 12) {
            $query->whereMonth('fecha_entrega', $this->mes)
                ->whereYear('fecha_entrega', $this->anio ?: now()->year);
        }

        if ($this->tipoFiltro === 'semana') {
            $query->whereBetween('fecha_entrega', [
                now()->startOfWeek()->startOfDay(),
                now()->endOfWeek()->endOfDay(),
            ]);
        }

        if ($this->tipoFiltro === 'anio') {
            $query->whereYear('fecha_entrega', $this->anio ?: now()->year);
        }

        return $query
            ->orderByDesc('fecha_entrega')
            ->orderByDesc('id')
            ->get()
            ->map(function ($item) {
                return [
                    'id'             => $item->id,
                    'apellido'       => $item->apellido,
                    'nombre'         => $item->nombre,
                    'dni'            => $item->dni,
                    'organizacion'   => $item->organizacion->nombre ?? null,
                    'cantidad'       => $item->cantidad ?? 1,
                    'fecha_entrega'  => $item->fecha_entrega
                        ? \Carbon\Carbon::parse($item->fecha_entrega)->format('d/m/Y')
                        : null,
                    'usuario'        => $item->usuario->username ?? 'Sistema',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Apellido',
            'Nombre',
            'DNI',
            'Organización',
            'Cantidad',
            'Fecha Entrega',
            'Usuario'
        ];
    }
}
