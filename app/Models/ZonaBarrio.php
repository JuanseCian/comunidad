<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ZonaBarrio
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Barrio[] $barrios
 *
 * @package App\Models
 */
class ZonaBarrio extends Model
{
	protected $table = 'zona_barrio';

	protected $fillable = [
		'nombre'
	];

	public function barrios()
	{
		return $this->hasMany(Barrio::class);
	}


}
