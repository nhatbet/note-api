<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Article $article */
        $article = $this->resource;

        $array = [
            'id' => $article->getKey(),
            'title' => $article->title,
            'content' => $article->content,
            'author_id' => $article->author_id,
            'status' => $article->status,
            'view_count' => $article->view_count,
            'category_id' => $article->category_id,
            'created_at' => $article->created_at,
        ];
        if ($article->relationLoaded('author')) {
            $array['author'] = new UserResource($article->author);
        }

        if ($article->relationLoaded('comments')) {
            $array['comments'] = CommentResource::collection($article->comments);
        }

        return $array;
    }
}
