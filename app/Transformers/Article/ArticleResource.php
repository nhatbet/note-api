<?php

namespace App\Transformers\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\User\UserResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $article = $this->resource;
        $array = [
            'id' => $article->getKey(),
            'title' => $article->title,
            'content' => $article->content,
            'status' => $article->status,
            'comments' => $article->comments,
            'author' => new UserResource($article->author),
            'created_at' => $article->created_at,
        ];

        return $array;
    }
}
