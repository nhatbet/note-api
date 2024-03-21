<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentUpdated
{
    use Dispatchable, SerializesModels;

    protected Comment $oldComment;
    protected Comment $newComment;
    protected User $editor;

    /**
     * Create a new event instance.
     */
    public function __construct(Comment $oldComment, Comment $newComment, User $editor)
    {
        $this->oldComment = $oldComment;
        $this->newComment = $newComment;
        $this->editor = $editor;
    }

    public function getOldComment(): Comment
    {
        return $this->oldComment;
    }

    public function getNewComment(): Comment
    {
        return $this->newComment;
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
