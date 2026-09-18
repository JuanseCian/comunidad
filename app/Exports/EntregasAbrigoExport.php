<?php

namespace App\Exports;

use App\Models\EntregaAbrigo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntregasAbrigoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return EntregaAbrigo::with('usuario')
            ->orderByDesc('fecha_entrega')
            ->get()
            ->map(function (EntregaAbrigo $item) {
                return [
                    $item->apellido,
                    $item->nombre,
                    $item->dni,
                    $item->colchones,
                    $item->frazadas,
                    $item->fecha_entrega?->format('d/m/Y'),
                    $item->usuario->username ?? 'Sistema',
                ];
            });
    }

    public function headings(): array
    {
        return ['Apellido', 'Nombre', 'DNI', 'Colchones', 'Frazadas', 'Fecha Entrega', 'Registrado por'];
    }
}
