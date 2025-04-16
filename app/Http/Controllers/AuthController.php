<?php

namespace App\Http\Controllers;

use App\DTOs\Users\LoginDto;
use App\Services\AuthService;
use App\Services\ApiResponseService;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param AuthService $authService The authentication service
     */
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Handle user login request.
     *
     * @param LoginRequest $request The login request containing email and password
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": {
     *     "token": "generated_jwt_token"
     *   }
     * }
     */
    public function login(LoginRequest $request)
    {
        return ApiResponseService::success([
            'token' => $this->authService->login(
                new LoginDto(email: $request->email, password: $request->password)
            )
        ]);
    }

    /**
     * Handle user logout request.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function logout()
    {
        $this->authService->logout();
        return ApiResponseService::success([], 200);
    }
}
