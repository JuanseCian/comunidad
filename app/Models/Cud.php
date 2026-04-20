<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cud
 * 
 * @property int $id
 * @property int $persona_id
 * @property bool|null $tiene_cud
 * @property string|null $numero_cud
 * @property Carbon|null $fecha_emision
 * @property Carbon|null $fecha_vencimiento
 * @property string|null $observaciones
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class Cud extends Model
{
	protected $table = 'cud';
	public $timestamps = false;

	protected $casts = [
		'persona_id' => 'int',
		'tiene_cud' => 'bool',
		'fecha_emision' => 'datetime',
		'fecha_vencimiento' => 'datetime'
	];

	protected $fillable = [
		'persona_id',
		'tiene_cud',
		'numero_cud',
		'fecha_emision',
		'fecha_vencimiento',
		'observaciones'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}
}
