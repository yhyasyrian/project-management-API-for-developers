<?php

namespace App\DTOs\Users;

use App\Models\User;

readonly class UpdateContactInformationDto
{
    public function __construct(
        public User $user,
        public string $value,
    ) {}
}
