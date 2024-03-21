<?php

namespace App\Listeners;

use App\Events\CommentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\CommentHistoryService;
use Illuminate\Support\Carbon;

class CreateCommentHistory
{
    private CommentHistoryService $commentHistoryService;

    /**
     * Create the event listener.
     */
    public function __construct(CommentHistoryService $commentHistoryService)
    {
        $this->commentHistoryService = $commentHistoryService;
    }

    /**
     * Handle the event.
     */
    public function handle(CommentUpdated $event): void
    {
        // TODO: Check OldComment != NewComment
        $this->commentHistoryService->store([
            'editor_id' => $event->getEditor()->getKey(),
            'old_value' => $event->getOldComment(),
            'new_value' => $event->getNewComment(),
            'edited_at' => Carbon::now(),
        ]);
    }
}
