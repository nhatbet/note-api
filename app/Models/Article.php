<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FullTextSearch;

class Article extends Model
{
    use HasFactory, SoftDeletes, FullTextSearch;

    protected $fillable = [
        'title',
        'content',
        'author_id',
        'status',
        'view_count',
        'category_id',
    ];

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'title',
    ];
    
    const STATUS_DRAFT = 1;
    const STATUS_PUBLIC = 2;
    const STATUS_PRIVATE = 3;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function saves(): MorphMany
    {
        return $this->morphMany(Save::class, 'saveable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(Article::class, 'editor_id', 'id');
    }
}
