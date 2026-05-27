<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NucleoConviviente extends Model
{
    protected $table = 'nucleos_convivientes';

    protected $fillable = [
        'familia_id',
        'domicilio_id',
        'descripcion',
        'activo',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'familia_id');
    }

    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class, 'domicilio_id');
    }

    /**
     * Personas titulares vinculadas a este núcleo (via persona_nucleo).
     */
    public function personas()
    {
        return $this->belongsToMany(
            Persona::class,
            'persona_nucleo',
            'nucleo_id',
            'persona_id'
        )->using(PersonaNucleoP::class)->withPivot('grupo_familiar_id');
    }

    /**
     * Miembros del grupo familiar vinculados a este núcleo (via persona_nucleo).
     */
    public function miembrosGrupoFamiliar()
    {
        return $this->belongsToMany(
            GrupoFamiliar::class,
            'persona_nucleo',
            'nucleo_id',
            'grupo_familiar_id'
        )->using(PersonaNucleoP::class);
    }
}
