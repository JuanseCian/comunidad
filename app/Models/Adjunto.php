<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    // La tabla solo tiene created_at
    const UPDATED_AT = null;

    protected $table = 'adjuntos';

    protected $fillable = [
        'entidad_tipo',
        'entidad_id',
        'nombre_original',
        'nombre_guardado',
        'ruta',
        'tipo_mime',
        'tamaño',
        'confidencial',
        'hash_sha256',
        'subido_por',
    ];

    // ── Relaciones ────────────────────────────────────────────────────────────

    public function subidoPor()
    {
        return $this->belongsTo(User::class, 'subido_por');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /** "1.4 MB" o "320.5 KB" */
    public function getTamañoFormateadoAttribute(): string
    {
        $bytes = $this->tamaño ?? 0;
        return $bytes >= 1_048_576
            ? number_format($bytes / 1_048_576, 2) . ' MB'
            : number_format($bytes / 1_024, 1) . ' KB';
    }

    /** Clase FontAwesome según tipo MIME */
    public function getIconoAttribute(): string
    {
        return match (true) {
            str_contains($this->tipo_mime ?? '', 'pdf')   => 'fa-file-pdf text-danger',
            str_contains($this->tipo_mime ?? '', 'image') => 'fa-file-image text-info',
            default                                        => 'fa-file text-secondary',
        };
    }
}
