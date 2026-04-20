<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoDocumento
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|GrupoFamiliar[] $grupo_familiars
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class TipoDocumento extends Model
{
	protected $table = 'tipo_documento';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function grupo_familiars()
	{
		return $this->hasMany(GrupoFamiliar::class, 'documento_id');
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'documento_id');
	}
}
