<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\NotificationRepository;
use App\Events\NotificationCreated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    protected NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $reqeust): LengthAwarePaginator
    {
        $query = $this->repository;
        if ($status = $reqeust->get('status')) {
            $query->where('status', $status);
        }
        if ($type = $reqeust->get('type')) {
            $query->where('type', $type);
        }
        $query->orderBy('created_at','desc');

        $notices = $query->paginate(10);

        return $notices;
    }

    public function store(array $attrs): Notification
    {
        $notice = $this->repository->create($attrs);

        NotificationCreated::dispatch($notice);

        return $notice;
    }

    public function updateToSent(Notification $notification)
    {
        $this->repository->update(['status' => Notification::STATUS_SENT], $notification->getKey());
    }

    public function countNotReadYet(Request $request): int
    {
        return $this->repository->where('receiver_id', $request->user()->getKey())->count();
    }
}
