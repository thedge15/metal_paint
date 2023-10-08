<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $projects
 */
class Bush extends Model
{
    use HasFactory;

//    public mixed $projects;
//    public mixed $title;
    protected $guarded = false;
    protected $table = 'bushes';

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class, 'bush_id', 'id');
    }
}
