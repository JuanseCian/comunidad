<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    protected $table = 'organizaciones';

    protected $fillable = [
        'nombre',
        'cuit_dni',
        'responsable',
        'telefono',
        'direccion',
        'cupo_mensual',
        'activo',
    ];

    protected $casts = [
        'activo'       => 'boolean',
        'cupo_mensual' => 'integer',
    ];

    public function mercaderias()
    {
        return $this->hasMany(Mercaderia::class);
    }

    /**
     * Total de bolsones entregados a esta organización en un mes/año dado.
     */
    public function bolsonesEntregados(?int $mes = null, ?int $anio = null): int
    {
        $mes ??= now()->month;
        $anio ??= now()->year;

        return $this->mercaderias()
            ->whereMonth('fecha_entrega', $mes)
            ->whereYear('fecha_entrega', $anio)
            ->sum('cantidad');
    }

    /**
     * Cupo restante para el mes/año dado. NULL = sin límite configurado.
     */
    public function cupoDisponible(?int $mes = null, ?int $anio = null): ?int
    {
        if (is_null($this->cupo_mensual)) {
            return null;
        }

        return max(0, $this->cupo_mensual - $this->bolsonesEntregados($mes, $anio));
    }
}
