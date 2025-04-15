<?php
namespace App\Services;

use App\Models\User;
use App\DTOs\Users\LoginDto;
use App\DTOs\Users\RegisterDto;
use App\Events\AccessAccount;
use App\Events\CreateAccount;
use App\Exceptions\PublicException;

class AuthService
{
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
    public function logout():void
    {
        auth()->logout();
    }
    public function changePassword(User $user = null, string $password):void
    {
        $user ??= auth()->user();
        $user->update(['password' => bcrypt($password)]);
    }
}
