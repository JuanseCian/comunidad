<?php

namespace App\Models\Estadisticas;

use App\Models\Estadisticas\Base\StatisticModel;

class AtencionPorUsuario extends StatisticModel
{
    protected $table = 'vw_atenciones_por_usuario';
}