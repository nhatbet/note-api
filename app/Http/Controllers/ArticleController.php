<?php

namespace App\Http\Controllers;

use App\Services\VoteService;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    protected ArticleService $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $index = $this->service->index($request);

        return responder()->getPaginator($index, ArticleResource::class);
    }

    public function getMyArticle(Request $request): JsonResponse
    {
        $index = $this->service->getMyArticle($request);

        return responder()->getPaginator($index, ArticleResource::class);
    }

    public function show(Article $article): JsonResponse
    {
        $article->load([
            'comments',
            'author' => function ($query) {
                $query->with([
                    'media' => function ($query) {
                        $query->where('collection_name', 'avatar');
                    }
                ]);
            }
        ]);
        $resource = new ArticleResource($article);

        return responder()->getSuccess($resource);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $article = $this->service->store($request->validated() + ['author_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $article
        ]);
    }

    public function update(UpdateRequest $request, Article $article): JsonResponse
    {
        $article = $this->service->update($article, $request->validated() + ['editor' => $request->user()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $article
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $this->service->delete($article);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }

    public function upVote(Request $request, Article $article): JsonResponse
    {
        /** @var VoteService $voteService  */
        $voteService = app(VoteService::class);
        $vote = $voteService->findVote($request->user(), $article);
        $vote = $voteService->up($vote);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $vote,
        ]);
    }

    public function downVote(Request $request, Article $article): JsonResponse
    {
        /** @var VoteService $voteService  */
        $voteService = app(VoteService::class);
        $vote = $voteService->findVote($request->user(), $article);
        $vote = $voteService->down($vote);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $vote,
        ]);
    }

    public function resetVote(Request $request, Article $article): JsonResponse
    {
        /** @var VoteService $voteService  */
        $voteService = app(VoteService::class);
        $vote = $voteService->findVote($request->user(), $article);
        $vote = $voteService->reset($vote);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $vote,
        ]);
    }
}
