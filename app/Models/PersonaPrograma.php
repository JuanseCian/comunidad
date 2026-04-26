<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonaPrograma
 * 
 * @property int $id
 * @property int $persona_id
 * @property int $programa_id
 * @property Carbon|null $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property bool $activo
 * @property string|null $observaciones
 * @property int|null $registrado_por
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Persona $persona
 * @property ProgramasAsistencium $programas_asistencium
 * @property User|null $user
 *
 * @package App\Models
 */
class PersonaPrograma extends Model
{
	protected $table = 'persona_programa';

	protected $casts = [
		'persona_id' => 'int',
		'programa_id' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime',
		'activo' => 'bool',
		'registrado_por' => 'int'
	];

	protected $fillable = [
		'persona_id',
		'programa_id',
		'rol',
		'fecha_inicio',
		'fecha_fin',
		'activo',
		'observaciones',
		'registrado_por'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function programa()
	{
		return $this->belongsTo(ProgramasAsistencia::class, 'programa_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'registrado_por');
	}
}
