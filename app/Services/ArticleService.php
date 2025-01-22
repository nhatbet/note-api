<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ArticleService
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $query = $this->repository
            ->where('status', Article::STATUS_PUBLIC)->with([
                    'author:id,name',
                    'author.media' => function ($query) {
                        $query->where('collection_name', 'avatar');
                    }
                ]);
        if ($title = $request->get('title')) {
            $query->search($title);
        }
        if ($tagsId = $request->get('tags_id')) {
            $query->whereHas('tags', function ($query) use ($tagsId) {
                $query->whereIn('tags.id', $tagsId);
            });
        }
        if ($categoriesId = $request->get('categories_id')) {
            $query->whereIn('category_id', $categoriesId);
        }

        $index = $query->paginate(9);

        return $index;
    }

    public function getMyArticle(Request $request)
    {
        $query = $this->repository
            ->where('author_id', $request->user()->getKey());
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($title = $request->has('title')) {
            $query->search($title);
        }

        $index = $query->paginate($request->get('per_page') ?? 20);

        return $index;
    }

    public function store(array $attrs): Article
    {
        $attrs['category_id'] = 1;
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

        // /** @var TagService $tagService */
        // $tagService = app(TagService::class);
        // $tagsSaved = $tagService->insert($attrs['tags']);
        // $tagService->sync($article, $tagsSaved);

        return $article;
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
