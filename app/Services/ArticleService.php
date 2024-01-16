<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Services\TagService;
use Illuminate\Support\Arr;

class ArticleService
{
    public function store(array $attrs): Article
    {
        /** @var ArticleRepository $articleRepo */
        $articleRepo = app(ArticleRepository::class);
        $article = $articleRepo->create(Arr::except($attrs, ['tags']));

        /** @var TagService $tagService */
        $tagService = app(TagService::class);
        $tagsSaved = $tagService->insert($attrs['tags']);
        $tagService->attach($article, $tagsSaved);

        return $article;
    }

    public function update(Article $article, array $attrs): Article
    {
        /** @var ArticleRepository $articleRepo */
        $articleRepo = app(ArticleRepository::class);
        $article = $articleRepo->update($attrs, $article->getKey());

        /** @var TagService $tagService */
        $tagService = app(TagService::class);
        $tagsSaved = $tagService->insert($attrs['tags']);
        $tagService->sync($article, $tagsSaved);

        return $article;
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
