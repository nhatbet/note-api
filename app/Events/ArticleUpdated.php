<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\User;

class ArticleUpdated
{
    use Dispatchable, SerializesModels;

    protected Article $oldArticle;
    protected Article $newArticle;
    protected User $editor;

    /**
     * Create a new event instance.
     */
    public function __construct(Article $oldArticle, Article $newArticle, User $editor)
    {
        $this->oldArticle = $oldArticle;
        $this->newArticle = $newArticle;
        $this->editor = $editor;
    }

    public function getOldArticle(): Article
    {
        return $this->oldArticle;
    }

    public function getNewArticle(): Article
    {
        return $this->newArticle;
    }

    public function getEditor(): User
    {
        return $this->editor;
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
