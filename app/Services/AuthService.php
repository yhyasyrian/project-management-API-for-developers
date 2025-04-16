<?php
namespace App\Services;

use App\Models\User;
use App\DTOs\Users\LoginDto;
use App\DTOs\Users\RegisterDto;
use App\Events\AccessAccount;
use App\Events\CreateAccount;
use App\Exceptions\PublicException;

/**
 * AuthService handles authentication-related operations including
 * user login, registration, logout, and password management.
 */
class AuthService
{
    /**
     * Authenticate a user and generate an access token.
     *
     * @param LoginDto $data The login credentials (email and password)
     * @return string The generated JWT token
     * @throws PublicException If authentication fails
     */
    public function login(LoginDto $data)
    {
        if (
            $token = auth()->attempt([
                'email' => $data->email,
                'password' => $data->password,
            ])
        ) {
            event(new AccessAccount(
                User::where('email', $data->email)->first()
            ));
            return $token;
        }
        throw new PublicException('Invalid credentials', 401);
    }

    /**
     * Register a new user account.
     *
     * @param RegisterDto $data The user registration data
     * @return void
     */
    public function register(RegisterDto $data):void
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);
        event(new CreateAccount($user));
        return;
    }

    /**
     * Log out the currently authenticated user.
     *
     * @return void
     */
    public function logout():void
    {
        auth()->logout();
    }

    /**
     * Change the password for a user.
     * If no user is provided, changes the password for the currently authenticated user.
     *
     * @param User|null $user The user to change password for (defaults to current user)
     * @param string $password The new password
     * @return void
     */
    public function changePassword(User $user = null, string $password):void
    {
        $user ??= auth()->user();
        $user->update(['password' => bcrypt($password)]);
    }
}
