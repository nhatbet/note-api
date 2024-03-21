<?php

namespace App\Listeners;

use App\Events\ArticleUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\ArticleHistoryService;
use Illuminate\Support\Carbon;

class CreateArticleHistory
{
    private ArticleHistoryService $articleHistoryService;

    /**
     * Create the event listener.
     */
    public function __construct(ArticleHistoryService $articleHistoryService)
    {
        $this->articleHistoryService = $articleHistoryService;
    }

    /**
     * Handle the event.
     */
    public function handle(ArticleUpdated $event): void
    {
        // TODO: Check OldArticle != NewArticle
        $this->articleHistoryService->store([
            'editor_id' => $event->getEditor()->getKey(),
            'old_value' => $event->getOldArticle(),
            'new_value' => $event->getNewArticle(),
            'edited_at' => Carbon::now(),
        ]);
    }
}
