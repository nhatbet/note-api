<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MediaResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;
   
        $array = [
            'id' => $user->getKey(),
            'name' => $user->name,
            'email' => $user->email,
            'dob' => $user->dob,
            'gender' => $user->gender,
            'created_at' => $user->created_at,
        ];
        if ($user->relationLoaded('media')) {
            $array['avatar'] = (new MediaResource($user->getMedia()->last()))['url'] ?? null;
        }

        return $array;
    }
}
