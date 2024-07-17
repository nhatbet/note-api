<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Events\ArticleUpdated;

class ArticleService
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $index = $this->repository->paginate(10);

        return $index;
    }

    public function store(array $attrs): Article
    {
        $article = $this->repository->create(Arr::except($attrs, ['tags']));

        // /** @var TagService $tagService */
        // $tagService = app(TagService::class);
        // $tagsSaved = $tagService->insert($attrs['tags']);
        // $tagService->attach($article, $tagsSaved);

        return $article;
    }

    public function update(Article $article, array $attrs): Article
    {
        $oldArticle = clone $article;
        $article = $this->repository->update($attrs, $article->getKey());

        /** @var TagService $tagService */
        $tagService = app(TagService::class);
        $tagsSaved = $tagService->insert($attrs['tags']);
        $tagService->sync($article, $tagsSaved);

        ArticleUpdated::dispatch($oldArticle, $article, $attrs['editor']);

        return $article;
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
