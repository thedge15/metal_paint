<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $guarded = false;
    protected $table = 'materials';
    /**
     * @return BelongsTo
     */
    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class, 'standard_id', 'id');
    }
    /**
     * @return BelongsTo
     */
    public function steel(): BelongsTo
    {
        return $this->belongsTo(Steel::class, 'steel_id', 'id');
    }
}


