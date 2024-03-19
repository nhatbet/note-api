<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeviceService;
use Illuminate\Http\JsonResponse;

class DeviceController extends Controller
{
    protected DeviceService $service;

    public function __construct(DeviceService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request): JsonResponse
    {
        $attrs = [
            'name' => $request->userAgent(),
            'token' => $request->get('token'),
            'user_id' => $request->user()->getKey(),
        ];
        $device = $this->service->store($attrs);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $device
        ]);
    }
}
