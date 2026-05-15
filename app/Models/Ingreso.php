<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';

    protected $fillable = [
        'dni',
        'nombre',
        'apellido',

        'persona_id',
        'user_id',
        'derivacion_id',

        'fecha_ingreso',
        'hora_ingreso',

        'observaciones',

        'menor_persona_id',
        'menor_dni',
        'menor_apellido',
        'menor_nombre',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function derivacion()
    {
        return $this->belongsTo(Derivacion::class);
    }

    public function menor()
    {
        return $this->belongsTo(Persona::class, 'menor_persona_id');
    }
}