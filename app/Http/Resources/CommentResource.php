<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Comment $comment */
        $comment = $this->resource;
        $array = [
            'id' => $comment->getKey(),
            'content' => $comment->content,
            'parent_id' => $comment->parent_id,
            'commentator_id' => $comment->commentator_id,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
            'comments_count' => $comment->comments_count,
        ];

        if ($comment->relationLoaded('commentator')) {
            $array['commentator'] = new UserResource($comment->commentator);
        }

        return $array;
    }
}
