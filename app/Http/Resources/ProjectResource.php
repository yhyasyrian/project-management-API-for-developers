<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'description' => $this->description,
            'client' => $this->whenLoaded('client', fn() => UserResource::make($this->client)->toArray($request)),
            'content' => $this->content,
            'price' => $this->price,
            'domain' => $this->url,
            'status' => $this->statusEnum->value,
            'start_at' => $this->start_at->format('Y/m/d'),
            'end_at' => $this->end_at->format('Y/m/d'),
            'countTask' => $this->whenCounted('tasks'),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
