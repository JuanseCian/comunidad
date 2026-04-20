<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ZonaBarrio
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|Barrio[] $barrios
 *
 * @package App\Models
 */
class ZonaBarrio extends Model
{
	protected $table = 'zona_barrio';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function barrios()
	{
		return $this->hasMany(Barrio::class);
	}
}
