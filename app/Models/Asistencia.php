<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'persona_id',
        'fecha',
        'presente',
        'registrado_por',
        'observaciones',
    ];

    protected $casts = [
        'fecha'    => 'date',
        'presente' => 'boolean',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
