<?php

namespace App\Listeners;

use App\Events\LoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\DeviceService;

class DeleteDevice implements ShouldQueue
{
    // public string $queue = 'delete-device';
    private DeviceService $deviceService;

    /**
     * Create the event listener.
     */
    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * Handle the event.
     */
    public function handle(LoggedOut $event): void
    {
        $this->deviceService->deleteByName($event->getDeviceName(), $event->getUserId());
    }
}
