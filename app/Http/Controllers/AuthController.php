<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->authService->authenticate($request->get('email'), $request->get('password')),
        ]);
    }
}
