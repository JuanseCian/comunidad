<?php

namespace App\Models\Estadisticas\Base;

use Illuminate\Database\Eloquent\Model;

class StatisticModel extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $guarded = [];

    protected $primaryKey = null;
}