<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $materials
 * @property mixed $elements
 * @property mixed $id
 */
class Project extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'projects';
    protected $with = 'bush';

    public function bush(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Bush::class, 'bush_id', 'id');
    }

    public function materials(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Material::class, 'project_id', 'id');
    }
}
