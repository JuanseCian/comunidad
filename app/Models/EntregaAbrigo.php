<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaAbrigo extends Model
{
    protected $table = 'entregas_abrigo';

    protected $fillable = [
        'persona_id',
        'familia_id',
        'user_id',
        'dni',
        'apellido',
        'nombre',
        'direccion',
        'colchones',
        'frazadas',
        'fecha_entrega',
        'observaciones',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'colchones' => 'integer',
        'frazadas' => 'integer',
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
