<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->authService->authenticate($request->get('username'), $request->get('password')),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null,
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

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->only(['email', 'name', 'username', 'password']));

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $user,
        ]);
    }
}
