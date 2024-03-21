<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'editor_id',
        'old_value',
        'new_value',
        'edited_at',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
