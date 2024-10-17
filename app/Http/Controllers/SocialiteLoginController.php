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
    public function loginWithProvider(Request $request): JsonResponse
    {
        $accessToken = $request->get('access_token');
        $provider = $request->get('provider');
        /** @var GGUser $ggUser */
        $ggUser = Socialite::with($provider)->stateless()->userFromToken($accessToken);
        /** @var UserRepository $userRepo */
        $userRepo = app(UserRepository::class);
        $user = $userRepo->updateOrCreate(
            [
                'provider_id' => $ggUser->id,
                'provider_name' => $provider,
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
