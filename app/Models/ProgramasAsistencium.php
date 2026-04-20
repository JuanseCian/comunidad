<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgramasAsistencium
 * 
 * @property int $id
 * @property string $nombre
 *
 * @package App\Models
 */
class ProgramasAsistencium extends Model
{
	protected $table = 'programas_asistencia';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];
}
