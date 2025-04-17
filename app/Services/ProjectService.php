<?php

namespace App\Services;

use App\Models\Project;
use App\DTOs\Projects\CreateDto;
use App\DTOs\Projects\UpdateDto;
use App\Traits\AuthorizationTrait;
use App\Http\Resources\ProjectResource;

/**
 * ProjectService handles all business logic related to projects
 * including CRUD operations and authorization checks.
 */
class ProjectService
{
    use AuthorizationTrait;

    // Number of projects per page for pagination
    private const PER_PAGE = 10;

    /**
     * ProjectService constructor.
     *
     * @param Project $project The Project model instance
     */
    public function __construct(
        private Project $project
    ) {}

    /**
     * Get a paginated list of all projects.
     *
     * @param int $page The page number for pagination
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getAll(int $page)
    {
        $this->canViewAny(Project::class);
        $projects = $this->project
            ->paginate(perPage: self::PER_PAGE, page: $page);
        return ProjectResource::collection($projects);
    }

    /**
     * Create a new project.
     *
     * @param CreateDto $dto The project creation data
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function create(CreateDto $dto)
    {
        $this->canCreate(Project::class);
        $this->project->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'user_id' => $dto->user->id,
            'content' => $dto->content,
            'price' => $dto->price,
            'url' => $dto->domain,
            'route_check' => $dto->route_check,
            'status' => $dto->status->getStatusNumber(),
            'can_check' => $dto->can_check ?? false,
            'start_at' => $dto->start_at,
            'end_at' => $dto->end_at,
        ]);
    }

    /**
     * Get details of a specific project by ID.
     *
     * @param string $id The project ID
     * @return ProjectResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If project not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getById(string $id)
    {
        $project = $this->project->withCount('tasks')->with(['tags', 'user'])->findOrFail($id);
        $this->canView($project);
        return new ProjectResource($project);
    }

    /**
     * Update an existing project's information.
     *
     * @param string $id The project ID
     * @param UpdateDto $dto The updated project data
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If project not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function update(string $id, UpdateDto $dto)
    {
        $project = $this->project->findOrFail($id);
        $this->canUpdate($project);
        $project->update([
            'name' => $dto->name,
            'description' => $dto->description,
            'user_id' => $dto->user->id,
            'content' => $dto->content,
            'price' => $dto->price,
            'url' => $dto->domain,
            'route_check' => $dto->route_check,
            'status' => $dto->status->getStatusNumber(),
            'can_check' => $dto->can_check ?? false,
            'start_at' => $dto->start_at,
            'end_at' => $dto->end_at,
        ]);
    }

    /**
     * Delete a project by ID.
     *
     * @param string $id The project ID
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If project not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function delete(string $id)
    {
        $project = $this->project->findOrFail($id);
        $this->canDelete($project);
        $project->delete();
    }
}
