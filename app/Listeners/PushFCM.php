<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\DeviceTokenService;
use App\Services\FCMService;
use App\Services\NotificationService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\NotFound;

class PushFCM implements ShouldQueue
{

    private FCMService $fCMService;
    private DeviceTokenService $deviceTokenService;
    private NotificationService $notificationService;

    public function __construct(FCMService $fCMService, DeviceTokenService $deviceTokenService, NotificationService $notificationService)
    {
        $this->fCMService = $fCMService;
        $this->deviceTokenService = $deviceTokenService;
        $this->notificationService = $notificationService;
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
        
        try {
            $this->fCMService->sendToDevice($token, $notice);
            $this->notificationService->updateToSent($notification);
        } catch (NotFound $exception) {
            Log::info($exception->getMessage());
        }
    }
}
