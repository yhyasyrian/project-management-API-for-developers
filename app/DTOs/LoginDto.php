<?php
namespace App\DTOs;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
