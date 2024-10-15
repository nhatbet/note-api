<?php

namespace App\Listeners;

use App\Events\CommentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\CommentHistoryService;
use Illuminate\Support\Carbon;
use App\Events\CommentCreated;
use App\Jobs\CreateNotification;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Question;
use Exception;
use App\Repositories\CommentRepository;

class CreateNoticeComment
{
    private CommentRepository $commentRepository;
    /**
     * Create the event listener.
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->getComment();
        $creator = $event->getCreator();
        $modelComment = $event->getModelComment();

        switch (true) {
            case $modelComment instanceof Article:
                if ($comment->parent_id == null) {
                    // Tự comment bài viết của mình
                    if ($modelComment->author_id === $comment->commentator_id) {
                        break;
                    }
                    CreateNotification::createForArticleOwner(
                        $modelComment->author_id,
                        $modelComment,
                        $comment,
                        $creator->name
                    );
                } else {
                    /** @var Comment $commentParent */
                    $commentParent = $this->commentRepository->find($comment->parent_id);
                    // Tự trả lời câu hỏi của mình
                    if ($comment->commentator_id === $commentParent->commentator_id) {
                        break;
                    }
                    CreateNotification::createForCommentOwner(
                        $commentParent->commentator_id,
                        $modelComment,
                        $comment,
                        $creator->name
                    );
                }

                break;
            case $modelComment instanceof Question:

                break;
            default:
                throw new Exception();
        }

    }
}
