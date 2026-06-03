<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Mercaderia;

class Familia extends Model
{
    protected $table = 'familias';

    protected $fillable = ['codigo'];

    public function personas()
    {
        return $this->hasMany(Persona::class, 'familia_id');
    }

    public static function generarCodigo(): string
    {
        do {
            $codigo = strtoupper(Str::random(3))
                    . random_int(100, 999)
                    . strtoupper(Str::random(3));
        } while (self::where('codigo', $codigo)->exists());

        return $codigo;
    }

    public static function eliminarSiVacia($familiaId): void
    {
        $familia = self::find($familiaId);

        if (!$familia) {
            return;
        }

        if ($familia->personas()->count() === 0) {
            $familia->delete();
        }
    }

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

    public function mercaderiasActivas()
    {
        return $this->hasMany(\App\Models\Mercaderia::class)
            ->whereDate('fecha_entrega', '>=', now()->subDays(30))
            ->latest('fecha_entrega');
    }

    public function sepelios()
    {
        return $this->hasMany(Sepelio::class);
    }
}
