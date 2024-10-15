<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentCreated
{
    use Dispatchable, SerializesModels;

    protected Comment $comment;
    // article | question
    protected Model $modelComment;
    protected User $creator;

    /**
     * Create a new event instance.
     */
    public function __construct(Comment $comment, Model $modelComment, User $creator)
    {
        $this->comment = $comment;
        $this->modelComment = $modelComment;
        $this->creator = $creator;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function getModelComment(): Model
    {
        return $this->modelComment;
    }

    public function getCreator(): User
    {
        return $this->creator;
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
