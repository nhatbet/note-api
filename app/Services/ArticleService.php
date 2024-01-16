<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;

class ArticleService
{
    public function store(array $attrs): Article
    {
        /** @var ArticleRepository $articleRepo */
        $articleRepo = app(ArticleRepository::class);
        $article = $articleRepo->create($attrs);

        return $article;
    }

    public function update(Article $article, array $attrs): Article
    {
        /** @var ArticleRepository $articleRepo */
        $articleRepo = app(ArticleRepository::class);
        $article = $articleRepo->update($attrs, $article->getKey());

        return $article;
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
