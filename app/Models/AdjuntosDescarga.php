<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdjuntosDescarga
 * 
 * @property int $id
 * @property int $adjunto_id
 * @property int $usuario_id
 * @property Carbon|null $fecha_descarga
 * @property string|null $ip
 * 
 * @property Adjunto $adjunto
 * @property User $user
 *
 * @package App\Models
 */
class AdjuntosDescarga extends Model
{
	protected $table = 'adjuntos_descargas';
	public $timestamps = false;

	protected $casts = [
		'adjunto_id' => 'int',
		'usuario_id' => 'int',
		'fecha_descarga' => 'datetime'
	];

	protected $fillable = [
		'adjunto_id',
		'usuario_id',
		'fecha_descarga',
		'ip'
	];

	public function adjunto()
	{
		return $this->belongsTo(Adjunto::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'usuario_id');
	}
}
