<?php

namespace App\Services;

use App\Models\Save;
use App\Models\User;
use App\Repositories\SaveRepository;
use Illuminate\Database\Eloquent\Model;

class SaveService
{
    protected SaveRepository $repository;

    public function __construct(SaveRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(Model $model): Save
    {
        $save = $model->saves()->create();

        return $save;
    }

    public function unSave(Save $save): void
    {
        $save->delete();
    }

    public function findSave(User $saver, Model $model): Save
    {
        $save = $this->repository->firstOrCreate([
            'saver_id' => $saver->getKey(),
            'saveable_id' => $model->getKey(),
            'saveable_type' => get_class($model),
        ]);

        return $save;
    }
}
