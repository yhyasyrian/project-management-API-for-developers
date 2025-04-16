<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\Users\UpdateDto;
use App\DTOs\Users\RegisterDto;
use App\Traits\AuthorizationTrait;
use App\Http\Resources\UserResource;

/**
 * UserService handles all user-related business logic including
 * CRUD operations, password management, and authorization checks.
 */
class UserService
{
    use AuthorizationTrait;

    // Number of users per page for pagination
    private const PER_PAGE = 10;

    /**
     * UserService constructor.
     *
     * @param User $user The User model instance
     * @param AuthService $authService The authentication service
     */
    public function __construct(
        private User $user,
        private AuthService $authService
    ){}

    /**
     * Get a paginated list of all users.
     *
     * @param int $page The page number for pagination
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getAllUsers(int $page)
    {
        $this->canViewAny(User::class);
        $users = $this->user
            ->paginate(self::PER_PAGE, page: $page)
            ->toResourceCollection();
        return UserResource::collection($users);
    }

    /**
     * Create a new user.
     *
     * @param RegisterDto $data The user registration data
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function createUser(RegisterDto $data)
    {
        $this->canCreate();
        return $this->authService->register($data);
    }

    /**
     * Get details of a specific user by ID.
     *
     * @param string $id The user ID
     * @return UserResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If user not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getUserById(string $id)
    {
        $user = $this->user->with(['projects', 'contactInformations'])->findOrFail($id);
        $this->canView($user);
        return UserResource::make($user);
    }

    /**
     * Update an existing user's information.
     *
     * @param string $id The user ID
     * @param UpdateDto $data The updated user data
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If user not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function updateUser(string $id, UpdateDto $data)
    {
        $user = $this->user->findOrFail($id);
        $this->canUpdate($user);
        $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'role' => $data->role->name,
        ]);
    }

    /**
     * Delete a user by ID.
     *
     * @param string $id The user ID
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If user not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function deleteUser(string $id)
    {
        $user = $this->user->findOrFail($id);
        $this->canDelete($user);
        $user->delete();
    }

    /**
     * Change a user's password.
     *
     * @param string $id The user ID
     * @param string $password The new password
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If user not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function changePassword(string $id, string $password)
    {
        $user = $this->user->findOrFail($id);
        $this->canUpdate($user);
        $this->authService->changePassword($user, $password);
    }
}
