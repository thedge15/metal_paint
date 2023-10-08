<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    protected $guarded = false;
    protected $table = 'characteristics';

    public function metal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Metal::class, 'metal_id', 'id');
    }
}
