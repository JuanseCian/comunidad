<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Usado exclusivamente como pivot en belongsToMany con ->using()
 */
class PersonaNucleoP extends Pivot
{
    protected $table = 'persona_nucleo';

    public $timestamps = false;
}
