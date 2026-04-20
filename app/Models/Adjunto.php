<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Adjunto
 * 
 * @property int $id
 * @property string $entidad_tipo
 * @property int $entidad_id
 * @property string $nombre_original
 * @property string $nombre_guardado
 * @property string $ruta
 * @property string|null $tipo_mime
 * @property int|null $tamaño
 * @property bool|null $confidencial
 * @property string|null $hash_sha256
 * @property int|null $subido_por
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 * @property Collection|AdjuntosDescarga[] $adjuntos_descargas
 *
 * @package App\Models
 */
class Adjunto extends Model
{
	protected $table = 'adjuntos';
	public $timestamps = false;

	protected $casts = [
		'entidad_id' => 'int',
		'tamaño' => 'int',
		'confidencial' => 'bool',
		'subido_por' => 'int'
	];

	protected $fillable = [
		'entidad_tipo',
		'entidad_id',
		'nombre_original',
		'nombre_guardado',
		'ruta',
		'tipo_mime',
		'tamaño',
		'confidencial',
		'hash_sha256',
		'subido_por'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'subido_por');
	}

	public function adjuntos_descargas()
	{
		return $this->hasMany(AdjuntosDescarga::class);
	}
}
