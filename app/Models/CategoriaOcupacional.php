<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriaOcupacional
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|GrupoFamiliar[] $grupo_familiars
 *
 * @package App\Models
 */
class CategoriaOcupacional extends Model
{
	protected $table = 'categoria_ocupacional';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function grupo_familiars()
	{
		return $this->hasMany(GrupoFamiliar::class);
	}
}
