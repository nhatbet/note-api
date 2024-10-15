<?php

namespace App\Listeners;

use App\Events\LoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\DeviceTokenService;

class DeleteDevice implements ShouldQueue
{
    // public string $queue = 'delete-device';
    private DeviceTokenService $deviceService;

    /**
     * Create the event listener.
     */
    public function __construct(DeviceTokenService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * Handle the event.
     */
    public function handle(LoggedOut $event): void
    {
        $this->deviceService->delete($event->getUserId());
    }
}
