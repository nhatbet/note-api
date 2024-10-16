<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Article;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'meta',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'meta' => 'json',
    ];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
