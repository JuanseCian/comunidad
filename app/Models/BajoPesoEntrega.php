<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BajoPesoEntrega extends Model
{
    protected $fillable = [
        'bajo_peso_id',
        'fecha',
        'prestacion',
        'firma',
        'observaciones'
    ];

    public function bajoPeso()
    {
        return $this->belongsTo(BajoPeso::class);
    }
}
