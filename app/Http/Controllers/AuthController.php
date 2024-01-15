<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->authService->authenticate($request->get('email'), $request->get('password')),
        ]);
    }

    public function refreshToken(Request $request): JsonResponse
    {
        $accessToken = $this->authService->createAccessToken($request->user());

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $accessToken->plainTextToken,
                'expires_at' => $accessToken->accessToken->expires_at,
            ],
        ]);
    }

    public function register(Request $request)
    {
        $user = $this->authService->register($request->only(['email', 'name', 'password']));

        return $user;
    }
}
