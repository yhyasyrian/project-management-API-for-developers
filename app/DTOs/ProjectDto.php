<?php
namespace App\DTOs;

use App\Enums\StatusProjectEnum;
use App\Models\User;

readonly class ProjectDto
{
    public function __construct(
        public string $name,
        public string $description,
        public User $user,
        public string $content,
        public float $price,
        public string $domain,
        public string $route_check,
        public StatusProjectEnum $status,
        public bool $can_check,
        public string $start_at,
        public ?string $end_at = null,
    ) {
    }
}