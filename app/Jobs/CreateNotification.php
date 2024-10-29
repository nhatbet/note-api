<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\NotificationService;

class CreateNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        // $this->onQueue('notification');
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notificationService): void
    {
        $notificationService->store($this->data);
    }

    static public function createForArticleOwner(int $receiverId, Article $article, Comment $comment, string $name): void
    {
        self::dispatch([
            'title' => "Bình luận mới",
            'body' => "$name vừa bình luận bài viết '$article->title' của bạn",
            'status' => Notification::STATUS_UNSENT,
            'receiver_id' => $receiverId,
            'type' => Notification::TYPE_1,
            'meta' => [
                'article_id' => $article->getKey(),
                'comment_id' => $comment->getKey(),
            ]
        ]);
    }

    static public function createForCommentOwner(int $receiverId, Article $article, Comment $comment, string $name): void
    {
        self::dispatch([
            'title' => "Bình luận phản hồi mới",
            'body' => "$name vừa trả lời bình luận của bạn trong bài viết '$article->title'",
            'status' => Notification::STATUS_UNSENT,
            'receiver_id' => $receiverId,
            'type' => Notification::TYPE_1,
            'meta' => [
                'article_id' => $article->getKey(),
                'comment_id' => $comment->getKey(),
            ]
        ]);
    }
}
