<?php

namespace App\DTOs\Experiences;

use Illuminate\Http\Request;

class CreateDto
{
    public function __construct(
        public string $name,
        public string $content,
        public string $start_date,
        public string $end_date,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new static(
            $request->input('name'),
            $request->input('content'),
            $request->input('start_date'),
            $request->input('end_date'),
        );
    }
}
