<?php

namespace App\Models\Estadisticas;

use App\Models\Estadisticas\Base\StatisticModel;

class IngresoPorUsuario extends StatisticModel
{
    protected $table = 'vw_ingresos_por_usuario';
}