<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->type->value,
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'contact_information' => ContactInformationResource::collection($this->whenLoaded('contactInformations')),
        ];
    }
}
