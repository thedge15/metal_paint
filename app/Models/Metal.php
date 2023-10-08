<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $characteristics
 */
class Metal extends Model
{
    protected $guarded = false;
    protected $table = 'metals';

    public function characteristics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Characteristic::class, 'metal_id', 'id');
    }

    public function standards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Standard::class, 'metal_id', 'id');
    }


}
