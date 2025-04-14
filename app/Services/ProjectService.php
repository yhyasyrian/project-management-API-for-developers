<?php

namespace App\Services;

use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectService
{
    public function __construct(private Project $project)
    {
    }
    public function getAllProjects($page)
    {
        $projects = $this->project
            ->with(['tags'])
            ->paginate($page)
            ->toResourceCollection();
        return ProjectResource::collection($projects);
    }
}
