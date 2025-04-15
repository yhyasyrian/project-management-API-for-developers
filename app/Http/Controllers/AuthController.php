<?php

namespace App\Http\Controllers;

use App\DTOs\Users\LoginDto;
use App\Services\AuthService;
use App\Services\ApiResponseService;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }
    public function login(LoginRequest $request)
    {
        return ApiResponseService::success([
            'token' => $this->authService->login(
                new LoginDto(email: $request->email, password: $request->password)
            )
        ]);
    }
    public function logout()
    {
        $this->authService->logout();
        return ApiResponseService::success([],200);
    }
}
