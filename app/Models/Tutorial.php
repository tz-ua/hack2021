<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutorial extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'project_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name'          => 'string',
        'project_id'    => 'int',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['steps'];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class, 'tutorial_id', 'id');
    }
}
