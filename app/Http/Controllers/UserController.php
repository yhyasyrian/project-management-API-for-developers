<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use App\DTOs\Users\UpdateDto;
use App\Services\UserService;
use App\DTOs\Users\RegisterDto;
use Illuminate\Validation\Rule;
use App\Services\ApiResponseService;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Requests\Users\ChangePasswordRequest;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ApiResponseService::success(
            $this->userService->getAllUsers($request->get('page', 1))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $this->userService->createUser(
            new RegisterDto(
                name: $request->get('name'),
                email: $request->get('email'),
                password: $request->get('password')
            )
        );
        return ApiResponseService::success([],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ApiResponseService::success(
            $this->userService->getUserById($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $request->validate([
            'email' => Rule::unique(User::class)->ignore($id),
        ]);
        $this->userService->updateUser($id, new UpdateDto(
            name: $request->get('name'),
            email: $request->get('email'),
            role: UserTypeEnum::from($request->get('role'))
        ));
        return ApiResponseService::success([],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);
        return ApiResponseService::success([],200);
    }
    /**
     * Change the password of the specified user.
     */
    public function changePassword(ChangePasswordRequest $request, string $id)
    {
        $this->userService->changePassword($id, $request->get('password'));
        return ApiResponseService::success([],200);
    }
}
