<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property int $id
 * @property string|null $nombre
 * @property string|null $apellido
 * @property string|null $correo
 * @property Carbon|null $fecha_nacimiento
 * @property int|null $documento_id
 * @property string|null $dni
 * @property int|null $sexo_id
 * @property int|null $domicilio_id
 * @property int|null $provincia_id
 * @property int|null $localidad_id
 * @property int|null $barrio_id
 * @property string|null $telefono
 * @property int|null $nivel_estudio_id
 * @property bool|null $trabaja
 * @property string|null $grupo_sanguineo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $sede_origen_id
 * 
 * @property Barrio|null $barrio
 * @property TipoDocumento|null $tipo_documento
 * @property Domicilio|null $domicilio
 * @property Localidad|null $localidad
 * @property NivelesEstudio|null $niveles_estudio
 * @property Provincium|null $provincium
 * @property Sexo|null $sexo
 * @property Sede|null $sede
 * @property Collection|Atencione[] $atenciones
 * @property Collection|Cud[] $cuds
 * @property Collection|GrupoFamiliar[] $grupo_familiars
 * @property Collection|Beneficio[] $beneficios
 * @property Collection|PersonaPrograma[] $persona_programas
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'personas';

	protected $casts = [
		'fecha_nacimiento' => 'datetime',
		'documento_id' => 'int',
		'sexo_id' => 'int',
		'domicilio_id' => 'int',
		'provincia_id' => 'int',
		'localidad_id' => 'int',
		'barrio_id' => 'int',
		'nivel_estudio_id' => 'int',
		'trabaja' => 'bool',
		'sede_origen_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'apellido',
		'correo',
		'fecha_nacimiento',
		'documento_id',
		'dni',
		'sexo_id',
		'domicilio_id',
		'provincia_id',
		'localidad_id',
		'barrio_id',
		'telefono',
		'nivel_estudio_id',
		'trabaja',
		'grupo_sanguineo',
		'sede_origen_id'
	];

	public function barrio()
	{
		return $this->belongsTo(Barrio::class);
	}

	public function tipo_documento()
	{
		return $this->belongsTo(TipoDocumento::class, 'documento_id');
	}

	public function domicilio()
	{
		return $this->belongsTo(Domicilio::class);
	}

	public function localidad()
	{
		return $this->belongsTo(Localidad::class);
	}

	public function niveles_estudio()
	{
		return $this->belongsTo(NivelesEstudio::class, 'nivel_estudio_id');
	}

	public function provincium()
	{
		return $this->belongsTo(Provincium::class, 'provincia_id');
	}

	public function sexo()
	{
		return $this->belongsTo(Sexo::class);
	}

	public function sede()
	{
		return $this->belongsTo(Sede::class, 'sede_origen_id');
	}

	public function atenciones()
	{
		return $this->hasMany(Atencione::class);
	}

	public function cuds()
	{
		return $this->hasMany(Cud::class);
	}

	public function grupo_familiars()
	{
		return $this->hasMany(GrupoFamiliar::class);
	}

	public function beneficios()
	{
		return $this->belongsToMany(Beneficio::class, 'persona_beneficio')
					->withPivot('id', 'fecha_otorgamiento', 'fecha_vencimiento', 'monto', 'activo', 'observaciones', 'registrado_por')
					->withTimestamps();
	}

	public function persona_programas()
	{
		return $this->hasMany(PersonaPrograma::class);
	}
}
