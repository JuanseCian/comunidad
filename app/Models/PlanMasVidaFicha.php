<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanMasVidaFicha extends Model
{
    protected $table = 'plan_mas_vida_fichas';

    protected $fillable = [
        'persona_beneficio_id',
        'fecha',
        'observaciones',
        'situacion_vivienda',
        'familia_numerosa',
        'casos_judiciales',
        'violencia_familiar',
        'desnutricion',
        'situacion_salud',
        'situacion_laboral',
        'trabajador_social',
    ];

    public function beneficio()
    {
        return $this->belongsTo(
            PersonaBeneficio::class,
            'persona_beneficio_id'
        );
    }

    public function integrantes()
    {
        return $this->hasMany(
            PlanMasVidaIntegrante::class,
            'ficha_id'
        );
    }
}