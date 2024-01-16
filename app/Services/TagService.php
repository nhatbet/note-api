<?php

namespace App\Services;

use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TagService
{
    protected TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function insert(array $tagNames): Collection
    {
        $tagsSaved = collect();
        foreach ($tagNames as $name) {
            $tag = $this->repository->firstOrCreate(['name' => $name]);
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
