<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanMasVidaIntegrante extends Model
{
    protected $table = 'plan_mas_vida_integrantes';

    protected $fillable = [
        'ficha_id',
        'apellido_nombre',
        'vinculo',
        'fecha_nacimiento',
        'cuil_dni',
        'vacunas',
        'embarazo',
        'discapacidad',
        'enfermedades',
        'asiste',
        'nivel_alcanzado',
        'escuela',
        'auh',
    ];

    public function ficha()
    {
        return $this->belongsTo(
            PlanMasVidaFicha::class,
            'ficha_id'
        );
    }
}