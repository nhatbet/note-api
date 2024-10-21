<?php

namespace App\Transformers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $user = $this->resource;
        $array = [
            'id' => $user->getKey(),
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->gender,
            'dob' => $user->dob,
            'avatar' => $user->media[0]?->original_url,
            'created_at' => $user->created_at,
        ];

        return $array;
    }
}
