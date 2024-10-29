<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Transformers\Notification\NotificationResource;

class NotificationController extends Controller
{
    protected NotificationService $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $reqeust) 
    {
        $paginator = $this->service->index($reqeust);
        $data = [
            'current_page' => $paginator->currentPage(),
            'data' => NotificationResource::collection($paginator->getCollection()),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ]);
    }
}
