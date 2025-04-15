<?php
namespace App\DTOs\Users;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
