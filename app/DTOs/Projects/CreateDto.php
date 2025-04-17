<?php
namespace App\DTOs\Projects;

use App\Models\User;
use App\Enums\ProjectStatusEnum;
use Illuminate\Http\Request;

readonly class CreateDto
{
    public User $user;
    public function __construct(
        public string $name,
        public string $description,
        private int $client_id,
        public string $content,
        public float $price,
        public string $domain,
        public string $route_check,
        public ProjectStatusEnum $status,
        public ?bool $can_check,
        public string $start_at,
        public ?string $end_at = null,
    ) {
        $this->user = User::findOrFail($client_id);
    }
    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            client_id: $request->input('client_id'),
            content: $request->input('content'),
            price: $request->input('price'),
            domain: $request->input('domain'),
            route_check: $request->input('route_check'),
            status: ProjectStatusEnum::from($request->input('status')),
            can_check: $request->input('can_check'),
            start_at: $request->input('start_at'),
            end_at: $request->input('end_at'),
        );
    }
}
