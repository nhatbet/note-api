<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Save extends Model
{
    use HasFactory;

    protected $fillable = [
        'saver_id',
        'saveable_id',
        'saveable_type',
        'status',
    ];

    const STATUS_SAVED = 1;
    const STATUS_DELETED = 2;

    public function saver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'saver_id');
    }

    public function saveable(): MorphTo
    {
        return $this->morphTo();
    }
}
