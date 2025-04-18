<?php

namespace App\DTOs\Certifications;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CreateDto
{
    public function __construct(
        public string $name,
        public string $description,
        public Carbon $date,
        public ?string $url,
        public ?string $id_check,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new static(
            $request->input('name'),
            $request->input('description'),
            Carbon::parse($request->input('date')),
            $request->input('url'),
            $request->input('id_check'),
        );
    }
}
