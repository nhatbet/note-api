<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\DeviceTokenService;
use App\Services\FCMService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class PushFCM implements ShouldQueue
{

    private FCMService $fCMService;
    private DeviceTokenService $deviceTokenService;

    public function __construct(FCMService $fCMService, DeviceTokenService $deviceTokenService)
    {
        $this->fCMService = $fCMService;
        $this->deviceTokenService = $deviceTokenService;
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationCreated $event): void
    {
        $notification = $event->getNotification();
        $deviceToken = $this->deviceTokenService->getByUserId($notification->receiver_id);
        if (!$deviceToken) {
            return;
        }
        $token = $deviceToken->token;
        $notice = $this->fCMService->createNotice($notification->title, $notification->body);
        $this->fCMService->sendToDevice($token, $notice);
    }
}
