<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Services\DeviceTokenService;
use App\Services\FCMService;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Messaging\Notification;
use App\Models\Notification as ModelNotify;


class DeviceTokenController extends Controller
{
    protected DeviceTokenService $service;
    public FCMService $fCMService;

    public function __construct(DeviceTokenService $service, FCMService $fCMService)
    {
        $this->service = $service;
        $this->fCMService = $fCMService;
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

    public function sendDemoToFirstToken(Request $request): JsonResponse
    {
        $notification = Notification::create('Chào mừng', 'Đây là thông báo thử nghiệm');
        $data = ['key' => 'value'];
        $deviceToken = DeviceToken::first()->token;
        $fcmService = app(FCMService::class); // Khởi tạo FCMService thông qua Laravel container
        $fcmService->send('token', $deviceToken, $notification, $data, 1);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }
}
