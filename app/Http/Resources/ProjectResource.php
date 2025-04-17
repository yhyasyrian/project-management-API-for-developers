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
            $this->mergeWhen(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->id == $this->client_id), [
                'countTask' => $this->whenCounted('tasks'),
                'price' => $this->price,
            ]),
            $this->mergeWhen(auth()->check() && auth()->user()->isAdmin(), [
                'client' => $this->whenLoaded('user', fn() => UserResource::make($this->user)),
            ]),
            'domain' => $this->url,
            'status' => $this->statusEnum->value,
            'start_at' => $this->start_at->format('Y/m/d'),
            'end_at' => $this->end_at->format('Y/m/d'),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
