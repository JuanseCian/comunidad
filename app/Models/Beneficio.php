<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Beneficio
 * 
 * @property int $id
 * @property string|null $nombre
 * 
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Beneficio extends Model
{
	protected $table = 'beneficios';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function personas()
	{
		return $this->belongsToMany(Persona::class, 'persona_beneficio')
					->withPivot('id', 'fecha_otorgamiento', 'fecha_vencimiento', 'monto', 'activo', 'observaciones', 'registrado_por')
					->withTimestamps();
	}
}
