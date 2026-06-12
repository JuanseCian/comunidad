<?php

namespace App\Exports;

use App\Models\Atencion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AtencionesExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?int $anio,
        protected ?int $mes,
        protected ?string $tipo
    ) {
    }

    public function collection()
    {
        return Atencion::with(['persona', 'users', 'sede'])
            ->when($this->anio, fn($query) => $query->whereYear('fecha_atencion', $this->anio))
            ->when($this->mes, fn($query) => $query->whereMonth('fecha_atencion', $this->mes))
            ->when($this->tipo, fn($query) => $query->where('tipo', $this->tipo))
            ->orderByDesc('fecha_atencion')
            ->get()
            ->map(function ($item) {
                return [
                    'apellido' => $item->persona->apellido ?? '',
                    'nombre' => $item->persona->nombre ?? '',
                    'fecha_atencion' => $item->fecha_atencion?->format('Y-m-d'),
                    'tipo' => $item->tipo,
                    'sede' => $item->sede->nombre ?? '',
                    'usuario' => $item->users->username ?? 'Sistema',
                    'descripcion' => $item->descripcion,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Apellido',
            'Nombre',
            'Fecha Atención',
            'Tipo',
            'Sede',
            'Usuario',
            'Descripción'
        ];
    }
}
