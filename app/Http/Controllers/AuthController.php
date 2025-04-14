<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDto;
use App\DTOs\RegisterDto;
use App\Services\AuthService;
use App\Services\ApiResponseService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

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
    public function register(RegisterRequest $request)
    {
        $this->authService->register(
            new RegisterDto(
                name: $request->name,
                email: $request->email,
                password: $request->password
            )
        );
        return ApiResponseService::success([],201);
    }
}
