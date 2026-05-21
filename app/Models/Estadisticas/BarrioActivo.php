<?php

namespace App\Models\Estadisticas;

use App\Models\Estadisticas\Base\StatisticModel;

class BarrioActivo extends StatisticModel
{
    protected $table = 'vw_barrios_mas_activos';
}