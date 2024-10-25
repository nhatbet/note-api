<?php

namespace App\Transformers\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\User\UserResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $comment = $this->resource;
        $array = [
            'id' => $comment->getKey(),
            'content' => $comment->content,
            'parent_id' => $comment->parent_id,
            'commentator_id' => $comment->commentator_id,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
            'comments_count' => $comment->comments_count,
            'commentator' => new UserResource($comment->commentator),
        ];

        return $array;
    }
}
