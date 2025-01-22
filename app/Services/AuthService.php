<?php

namespace App\Services;

use App\Events\RegisteredAccount;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    public function authenticate(string $username, string $password): array
    {
        /** @var UserRepository $userRepo */
        $userRepo = app(UserRepository::class);
        /** @var ?User $user */
        $user = $userRepo->findByField('username', $username)->first()->load([
            'media' => function ($query) {
                $query->where('collection_name', 'avatar');
            }
        ]);
        $userResource = new UserResource($user);

        if (!$user || !Hash::check($password, $user->password)) {
            // handle error
            throw new AuthenticationException('Username or password is incorrect');
        }
        $accessToken = $this->createAccessToken($user);
        $refreshToken = $user->createToken('refresh_token', ['issue-access-token'], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

        return [
            'token_type' => 'Bearer',
            'access_token' => $accessToken->plainTextToken,
            'expires_at' => $accessToken->accessToken->expires_at,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => $userResource
        ];
    }

    public function createAccessToken(User $user): NewAccessToken
    {
        return $user->createToken('access_token', ['access-api'], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
    }

    public function register(array $attrs): User
    {
        $userRepo = app(UserRepository::class);
        $user = $userRepo->create($attrs);

        RegisteredAccount::dispatch($user);

        return $user;
    }
}
