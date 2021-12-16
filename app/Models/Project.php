<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name'          => 'string',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    //protected $with = ['tutorials'];

    /**
     * @return HasMany
     */
    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class, 'project_id', 'id');
    }
}
