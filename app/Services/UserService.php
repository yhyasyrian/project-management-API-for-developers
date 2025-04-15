<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\Users\UpdateDto;
use App\DTOs\Users\RegisterDto;
use App\Traits\AuthorizationTrait;
use App\Http\Resources\UserResource;

class UserService
{
    use AuthorizationTrait;
    private const PER_PAGE = 10;
    public function __construct(
        private User $user,
        private AuthService $authService
    ){}
    public function getAllUsers(int $page)
    {
        $this->canViewAny(User::class);
        $users = $this->user
            ->paginate(self::PER_PAGE, page: $page)
            ->toResourceCollection();
        return UserResource::collection($users);
    }
    public function createUser(RegisterDto $data)
    {
        $this->canCreate();
        return $this->authService->register($data);
    }
    public function getUserById(string $id)
    {
        $user = $this->user->with(['projects', 'contactInformation'])->findOrFail($id);
        $this->canView($user);
        return UserResource::make($user);
    }
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
    public function deleteUser(string $id)
    {
        $user = $this->user->findOrFail($id);
        $this->canDelete($user);
        $user->delete();
    }
    public function changePassword(string $id, string $password)
    {
        $user = $this->user->findOrFail($id);
        $this->canUpdate($user);
        $this->authService->changePassword($user, $password);
    }
}
