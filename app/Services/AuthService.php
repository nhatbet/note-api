<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function authenticate(string $email, string $password): array
    {
        /** @var UserRepository $userRepo */
        $userRepo = app(UserRepository::class);
        /** @var ?User $user */
        $user = $userRepo->findByField('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            // handle error
            throw new AuthenticationException;
        }
        $accessToken = $user->createToken('access_token', ['access-api'], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $refreshToken = $user->createToken('refresh_token', ['issue-access-token'], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

        return [
            'token_type' => 'Bearer',
            'access_token' => $accessToken->plainTextToken,
            'expires_at' => $accessToken->accessToken->expires_at,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => $user,
        ];
    }
}
