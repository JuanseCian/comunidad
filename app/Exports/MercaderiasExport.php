<?php

namespace App\Exports;

use App\Models\Mercaderia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MercaderiasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Mercaderia::with('usuario')
            ->get()
            ->map(function ($item) {

                return [
                    'apellido'       => $item->apellido,
                    'nombre'         => $item->nombre,
                    'fecha_entrega'  => $item->fecha_entrega,
                    'usuario'        => $item->usuario->username ?? 'Sistema',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Apellido',
            'Nombre',
            'Fecha Entrega',
            'Usuario'
        ];
    }
}