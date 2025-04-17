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

/**
 * UserController handles all user-related operations including
 * CRUD operations and password management.
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param UserService $userService The service handling user-related business logic
     */
    public function __construct(
        private UserService $userService
    ) {
    }

    /**
     * Get a paginated list of all users.
     *
     * @param Request $request The HTTP request containing optional page parameter
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "role": "user"
     *     }
     *   ]
     */
    public function index(Request $request)
    {
        return ApiResponseService::success(
            $this->userService->getAll($request->get('page', 1))
        );
    }

    /**
     * Create a new user.
     *
     * @param CreateRequest $request The validated request containing user details
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function store(CreateRequest $request)
    {
        $this->userService->create(
            new RegisterDto(
                name: $request->get('name'),
                email: $request->get('email'),
                password: $request->get('password')
            )
        );
        return ApiResponseService::success([], 201);
    }

    /**
     * Get details of a specific user.
     *
     * @param string $id The ID of the user to retrieve
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": {
     *     "id": 0,
     *     "name": "string",
     *     "email": "string",
     *     "role": "developer",
     *     "projects": [
     *       {
     *         "id": 0,
     *         "name": "string",
     *         "description": "string",
     *         "content": "string",
     *         "price": "string",
     *         "domain": "string",
     *         "status": "success",
     *         "start_at": "2025-04-17T18:48:13.832Z",
     *         "end_at": "2025-04-17T18:48:13.832Z"
     *       }
     *     ],
     *     "contact_information": [
     *       {
     *         "id": 0,
     *         "label": "whatsapp",
     *         "value": "string"
     *       }
     *     ]
     *   }
     * }
     */
    public function show(string $id)
    {
        return ApiResponseService::success(
            $this->userService->getById($id)
        );
    }

    /**
     * Update an existing user's information.
     *
     * @param UpdateRequest $request The validated request containing updated user details
     * @param string $id The ID of the user to update
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function update(UpdateRequest $request, string $id)
    {
        $request->validate([
            'email' => Rule::unique(User::class)->ignore($id),
        ]);
        $this->userService->update($id, new UpdateDto(
            name: $request->get('name'),
            email: $request->get('email'),
            role: UserTypeEnum::from($request->get('role'))
        ));
        return ApiResponseService::success([], 200);
    }

    /**
     * Delete a user.
     *
     * @param string $id The ID of the user to delete
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function destroy(string $id)
    {
        $this->userService->delete($id);
        return ApiResponseService::success([], 200);
    }

    /**
     * Change a user's password.
     *
     * @param ChangePasswordRequest $request The validated request containing new password
     * @param string $id The ID of the user whose password to change
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function changePassword(ChangePasswordRequest $request, string $id)
    {
        $this->userService->changePassword($id, $request->get('password'));
        return ApiResponseService::success([], 200);
    }
}
