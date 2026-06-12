<?php

namespace App\Exports;

use App\Models\PersonaPrograma;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DestinatariosExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected string $programaNombre,
        protected ?int $sedeId,
        protected ?int $anio,
        protected ?int $mes
    ) {
    }

    public function collection()
    {
        return PersonaPrograma::with(['persona', 'programa', 'sede'])
            ->whereHas('programa', fn($q) => $q->where('nombre', 'like', "%{$this->programaNombre}%"))
            ->when($this->sedeId, fn($query) => $query->where('sede_id', $this->sedeId))
            ->when($this->anio, fn($query) => $query->whereYear('fecha_inicio', $this->anio))
            ->when($this->mes, fn($query) => $query->whereMonth('fecha_inicio', $this->mes))
            ->orderByDesc('fecha_inicio')
            ->get()
            ->map(function ($item) {
                return [
                    'apellido' => $item->persona->apellido ?? '',
                    'nombre' => $item->persona->nombre ?? '',
                    'programa' => $item->programa->nombre ?? '',
                    'rol' => $item->rol,
                    'fecha_inicio' => $item->fecha_inicio?->format('Y-m-d'),
                    'fecha_fin' => $item->fecha_fin?->format('Y-m-d'),
                    'activo' => $item->activo ? 'Sí' : 'No',
                    'sede' => $item->sede->nombre ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Apellido',
            'Nombre',
            'Programa',
            'Rol',
            'Fecha Inicio',
            'Fecha Fin',
            'Activo',
            'Sede'
        ];
    }
}
