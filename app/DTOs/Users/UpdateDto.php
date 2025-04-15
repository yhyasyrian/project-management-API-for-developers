<?php

namespace App\DTOs\Users;

use App\Enums\UserTypeEnum;

readonly class UpdateDto
{
    public function __construct(
        public string $name,
        public string $email,
        public UserTypeEnum $role,
    ) {}
}
