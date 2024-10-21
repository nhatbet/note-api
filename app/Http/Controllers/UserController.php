<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Transformers\User\UserResource;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->service->update($request->user()->getKey(), $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $user
        ]);
    }

    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user()->load([
            'media' => function ($query) {
                $query->where('collection_name', 'avatar');
            }
        ]);
        $resource = new UserResource($user);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $resource
        ]);
    }
}
