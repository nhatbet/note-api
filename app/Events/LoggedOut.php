<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoggedOut
{
    use Dispatchable, SerializesModels;

    protected int $userId;
    protected ?string $deviceName;

    /**
     * Create a new event instance.
     */
    public function __construct(int $userId, ?string $deviceName)
    {
        $this->userId = $userId;
        $this->deviceName = $deviceName;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDeviceName(): ?string
    {
        return $this->deviceName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('channel-name'),
        ];
    }
}
