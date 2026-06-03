<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sepelio extends Model
{
    protected $fillable = [

        'persona_id',
        'familia_id',
        'user_id',

        'dni',
        'apellido',
        'nombre',

        'fallecido_nombre',
        'fallecido_dni',
        'fecha_fallecimiento',

        'solicitante',
        'domicilio',
        'barrio',
        'caracter',

        'tipo_sepelio',
        'categoria_servicio',
        'mantenimiento',
        
        'costo',
        'fecha_solicitud',
        
        'observaciones',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}