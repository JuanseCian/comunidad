<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mercaderia extends Model
{
    protected $table = 'mercaderias';

    protected $fillable = [
        'persona_id',
        'familia_id',
        'user_id',
        'dni',
        'direccion',
        'apellido',
        'nombre',
        'fecha_entrega',
        'observaciones'
    ];

    public function persona()
    {
        return $this->belongsTo(
            Persona::class,
            'persona_id'
        );
    }

    public function familia()
    {
        return $this->belongsTo(
            Familia::class,
            'familia_id'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
    
    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class);
    }
    
}