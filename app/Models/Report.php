<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'type',
        'reporter_id',
        'reportable_id',
        'reportable_type',
    ];

    const TYPE_1 = 1;
    const TYPE_2 = 2;
    const TYPE_3 = 3;
    const TYPE_4 = 4;
    const TYPE_NAME_1 = 'Harassment';
    const TYPE_NAME_2 = 'Rules Violation';
    const TYPE_NAME_3 = 'Spam';
    const TYPE_NAME_4 = 'AI-generated';

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
