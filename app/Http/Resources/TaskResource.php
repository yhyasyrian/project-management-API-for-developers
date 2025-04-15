<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'project' => $this->whenLoaded('project', fn () => $this->project->name),
            'status' => $this->status->value,
            'client_view' => $this->can_view_for_client,
            'content' => $this->content,
        ];
    }
}
