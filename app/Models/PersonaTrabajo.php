<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaTrabajo extends Model
{
    protected $table = 'persona_trabajo';

    protected $fillable = [
        'persona_id',
        'situacion_ocupacional_id',
        'categoria_ocupacional_id',
        'descripcion',
        'empleador',
        'cargo',
        'ingresos',
        'fecha_inicio',
        'fecha_fin',
        'observaciones',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'ingresos'     => 'decimal:2',
    ];

    // ── Relaciones ────────────────────────────────────────────────────────────

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function situacionOcupacional()
    {
        return $this->belongsTo(SituacionOcupacional::class);
    }

    public function categoriaOcupacional()
    {
        return $this->belongsTo(CategoriaOcupacional::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Trabajo vigente: fecha_fin IS NULL */
    public function scopeActual($query)
    {
        return $query->whereNull('fecha_fin');
    }

    /** Historial: trabajos ya finalizados */
    public function scopeHistorial($query)
    {
        return $query->whereNotNull('fecha_fin');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getIngresosFormateadoAttribute(): string
    {
        return $this->ingresos
            ? '$' . number_format($this->ingresos, 0, ',', '.')
            : '—';
    }

    public function getEsActualAttribute(): bool
    {
        return is_null($this->fecha_fin);
    }
}
