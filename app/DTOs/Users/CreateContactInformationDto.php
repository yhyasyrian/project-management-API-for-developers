<?php

namespace App\DTOs\Users;

use App\Enums\ContactTypeEnum;
use App\Models\User;

readonly class CreateContactInformationDto
{
    public function __construct(
        public User $user,
        public ContactTypeEnum $type,
        public string $value,
    ) {}
}
