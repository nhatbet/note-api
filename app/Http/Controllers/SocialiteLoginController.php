<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GGUser;

class SocialiteLoginController extends Controller
{
    public function googleSignInUrl(): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => [
                'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
            ]
        ]);
    }

    public function googleCallback(Request $request): JsonResponse
    {
        /** @var GGUser $ggUser */
        // $ggUser = Socialite::driver('google')->stateless()->user();
        $ggUser = Socialite::with($request->provider)->stateless()->userFromToken($request->access_token);
        /** @var UserRepository $userRepo */
        $userRepo = app(UserRepository::class);
        $user = $userRepo->updateOrCreate(
            [
                'provider_id' => $ggUser->id,
                'provider_name' => 'google',
            ],
            [
                'name' => $ggUser->name,
                'email' => $ggUser->email,
            ]
        );

        /** @var AuthService $authService */
        $authService = app(AuthService::class);
        $accessToken = $authService->createAccessToken($user);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $accessToken->plainTextToken,
                'expires_at' => $accessToken->accessToken->expires_at,
                'user' => $user,
            ],
        ]);
    }
}
