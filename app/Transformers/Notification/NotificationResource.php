<?php

namespace App\Transformers\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $notice = $this->resource;
        $array = [
            'id' => $notice->getKey(),
            'title' => $notice->title,
            'body' => $notice->body,
            'type' => $notice->type,
            'status' => $notice->status,
            'meta' => $notice->meta,
            'created_at' => $notice->created_at,
            'updated_at' => $notice->updated_at,
        ];

        return $array;
    }
}
