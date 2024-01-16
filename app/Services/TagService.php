<?php

namespace App\Services;

use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TagService
{
    public function insert(array $tagNames): Collection
    {
        $tagsSaved = collect();
        /** @var TagRepository $tagRepo */
        $tagRepo = app(TagRepository::class);

        foreach ($tagNames as $name) {
            $tag = $tagRepo->firstOrCreate(['name' => $name]);
            $tagsSaved->push($tag);
        }

        return $tagsSaved;
    }

    public function attach(Model $model, Collection $tag): void
    {
        $model->tags()->attach($tag->pluck('id'));
    }

    public function sync(Model $model, Collection $tag): void
    {
        $model->tags()->sync($tag->pluck('id'));
    }
}
