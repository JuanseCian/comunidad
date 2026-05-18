<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Mercaderia;

class Familia extends Model
{
    protected $table = 'familias';

    protected $fillable = ['codigo'];

    // -------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------

    public function personas()
    {
        return $this->hasMany(Persona::class, 'familia_id');
    }

    // -------------------------------------------------------
    // Generación de código único
    // Formato: 3 letras mayúsculas + 3 dígitos + 3 letras mayúsculas
    // Ejemplo: KAR-482-XTQ  →  guardado sin guiones: KAR482XTQ
    // -------------------------------------------------------

    public static function generarCodigo(): string
    {
        do {
            $codigo = strtoupper(Str::random(3))
                    . random_int(100, 999)
                    . strtoupper(Str::random(3));
        } while (self::where('codigo', $codigo)->exists());

        return $codigo;
    }

    // Devuelve el código formateado con guiones para mostrar en UI
    public function getCodigoFormateadoAttribute(): string
    {
        return substr($this->codigo, 0, 3)
             . '-' . substr($this->codigo, 3, 3)
             . '-' . substr($this->codigo, 6, 3);
    }

    public function mercaderias()
    {
        return $this->hasMany(Mercaderia::class, 'familia_id');
    }
}
