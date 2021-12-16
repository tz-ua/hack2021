<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Step extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content',
        'tutorial_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'title'          => 'string',
        'content'        => 'json',
        'tutorial_id'    => 'int',
    ];

    /**
     * @return BelongsTo
     */
    public function tutorial(): BelongsTo
    {
        return $this->belongsTo(Tutorial::class, 'tutorial_id', 'id');
    }
}
