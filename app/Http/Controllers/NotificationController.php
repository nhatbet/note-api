<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected NotificationService $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse 
    {
        $paginator = $this->service->index($request);
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

    public function countNotReadYet(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->service->countNotReadYet($request)
        ]);
    }
}
