<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\NotificationRepository;
use App\Events\NotificationCreated;

class NotificationService
{
    protected NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attrs): Notification
    {
        $notice = $this->repository->create($attrs);

        NotificationCreated::dispatch($notice);

        return $notice;
    }
}
