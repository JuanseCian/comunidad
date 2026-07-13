<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sede
 * 
 * @property int $id
 * @property string $nombre
 * @property string|null $direccion
 * @property int|null $barrio_id
 * @property string|null $telefono
 * @property string|null $email
 * @property bool $activa
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Barrio|null $barrio
 * @property Collection|Atencione[] $atenciones
 * @property Collection|Persona[] $personas
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Sede extends Model
{
	use SoftDeletes;
	protected $table = 'sedes';

	protected $casts = [
		'barrio_id' => 'int',
		'activa' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'direccion',
		'barrio_id',
		'telefono',
		'email',
		'activa'
	];

	public function barrio()
	{
		return $this->belongsTo(Barrio::class);
	}

	public function atenciones()
	{
		return $this->hasMany(Atencione::class);
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'sede_origen_id');
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
	public function programa()
    {
        return $this->belongsTo(ProgramaAsistencia::class, 'programa_id');
    }
	 public function scopeGenerales($query)
    {
        return $query->whereNull('programa_id');
    }
 
    /**
     * Sedes generales + las exclusivas del programa indicado.
     */
    public function scopeParaPrograma($query, $programaId)
    {
        return $query->where(function ($q) use ($programaId) {
            $q->whereNull('programa_id')
              ->orWhere('programa_id', $programaId);
        });
    }
}
