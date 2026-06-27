<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BajoPeso extends Model
{
    protected $fillable = [
        'persona_id',
        'familia_id',
        'apellido_nombre',
        'dni',
        'fecha_nacimiento',
        'edad',
        'domicilio',
        'diagnostico',
        'tratamiento',

        'certificado_bajo_peso',
        'informe_socioambiental',

        'tutor_nombre',
        'tutor_dni',
        'tutor_parentesco',
        'tutor_responsable',
        
        'activo',
        'observaciones'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class);
    }

    public function entregas()
    {
        return $this->hasMany(BajoPesoEntrega::class);
    }
}  
