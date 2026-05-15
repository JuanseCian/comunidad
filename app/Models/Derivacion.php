<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    protected $table = 'derivaciones';

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class);
    }
}