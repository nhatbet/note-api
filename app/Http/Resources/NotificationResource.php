<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Notification;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Notification $notice */
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
