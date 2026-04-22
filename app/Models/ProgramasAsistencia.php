<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgramasAsistencium
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|PersonaPrograma[] $persona_programas
 *
 * @package App\Models
 */
class ProgramasAsistencia extends Model
{
	protected $table = 'programas_asistencia';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function persona_programas()
	{
		return $this->hasMany(PersonaPrograma::class, 'programa_id');
	}
}
