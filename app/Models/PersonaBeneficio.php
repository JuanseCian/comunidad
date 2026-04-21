<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonaBeneficio
 * 
 * @property int $id
 * @property int $persona_id
 * @property int $beneficio_id
 * @property Carbon|null $fecha_otorgamiento
 * @property Carbon|null $fecha_vencimiento
 * @property float|null $monto
 * @property bool $activo
 * @property string|null $observaciones
 * @property int|null $registrado_por
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Beneficio $beneficio
 * @property Persona $persona
 * @property User|null $user
 *
 * @package App\Models
 */
class PersonaBeneficio extends Model
{
	protected $table = 'persona_beneficio';

	protected $casts = [
		'persona_id' => 'int',
		'beneficio_id' => 'int',
		'fecha_otorgamiento' => 'datetime',
		'fecha_vencimiento' => 'datetime',
		'monto' => 'float',
		'activo' => 'bool',
		'registrado_por' => 'int'
	];

	protected $fillable = [
		'persona_id',
		'beneficio_id',
		'fecha_otorgamiento',
		'fecha_vencimiento',
		'monto',
		'activo',
		'observaciones',
		'registrado_por'
	];

	public function beneficio()
	{
		return $this->belongsTo(Beneficio::class);
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'registrado_por');
	}
}
