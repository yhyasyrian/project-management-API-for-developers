<?php

namespace App\Services;

use App\Models\Experience;
use App\DTOs\Experiences\CreateDto;
use App\DTOs\Experiences\UpdateDto;
use App\Traits\AuthorizationTrait;
use App\Http\Resources\ExperienceResource;

/**
 * ExperienceService handles all business logic related to experiences
 * including CRUD operations and authorization checks.
 */
class ExperienceService
{
    use AuthorizationTrait;

    // Number of experiences per page for pagination
    private const PER_PAGE = 10;

    /**
     * ExperienceService constructor.
     *
     * @param Experience $experience The Experience model instance
     */
    public function __construct(
        private Experience $experience
    ) {}

    /**
     * Get a paginated list of all experiences.
     *
     * @param int $page The page number for pagination
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getAll(int $page)
    {
        $this->canViewAny(Experience::class);
        $experiences = $this->experience
            ->paginate(perPage: self::PER_PAGE, page: $page);
        return ExperienceResource::collection($experiences);
    }

    /**
     * Create a new experience.
     *
     * @param CreateDto $dto The experience creation data
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function create(CreateDto $dto)
    {
        $this->canCreate(Experience::class);
        $this->experience->create([
            'name' => $dto->name,
            'content' => $dto->content,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
        ]);
    }

    /**
     * Get details of a specific experience by ID.
     *
     * @param string $id The experience ID
     * @return ExperienceResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If experience not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getById(string $id)
    {
        $experience = $this->experience->findOrFail($id);
        $this->canView($experience);
        return new ExperienceResource($experience);
    }

    /**
     * Update an existing experience's information.
     *
     * @param string $id The experience ID
     * @param UpdateDto $dto The updated experience data
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If experience not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function update(string $id, UpdateDto $dto)
    {
        $experience = $this->experience->findOrFail($id);
        $this->canUpdate($experience);
        $experience->update([
            'name' => $dto->name,
            'content' => $dto->content,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
        ]);
    }

    /**
     * Delete an experience by ID.
     *
     * @param string $id The experience ID
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If experience not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function delete(string $id)
    {
        $experience = $this->experience->findOrFail($id);
        $this->canDelete($experience);
        $experience->delete();
    }
}
