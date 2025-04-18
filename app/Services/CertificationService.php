<?php

namespace App\Services;

use App\Models\Certification;
use App\DTOs\Certifications\CreateDto;
use App\DTOs\Certifications\UpdateDto;
use App\Traits\AuthorizationTrait;
use App\Http\Resources\CertificationResource;

/**
 * CertificationService handles all business logic related to certifications
 * including CRUD operations and authorization checks.
 */
class CertificationService
{
    use AuthorizationTrait;

    // Number of certifications per page for pagination
    private const PER_PAGE = 10;

    /**
     * CertificationService constructor.
     *
     * @param Certification $certification The Certification model instance
     */
    public function __construct(
        private Certification $certification
    ) {}

    /**
     * Get a paginated list of all certifications.
     *
     * @param int $page The page number for pagination
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getAll(int $page)
    {
        $this->canViewAny(Certification::class);
        $certifications = $this->certification
            ->paginate(perPage: self::PER_PAGE, page: $page);
        return CertificationResource::collection($certifications);
    }

    /**
     * Create a new certification.
     *
     * @param CreateDto $dto The certification creation data
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function create(CreateDto $dto)
    {
        $this->canCreate(Certification::class);
        $this->certification->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'date' => $dto->date,
            'url' => $dto->url,
            'id_check' => $dto->id_check,
        ]);
    }

    /**
     * Get details of a specific certification by ID.
     *
     * @param string $id The certification ID
     * @return CertificationResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If certification not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function getById(string $id)
    {
        $certification = $this->certification->findOrFail($id);
        $this->canView($certification);
        return new CertificationResource($certification);
    }

    /**
     * Update an existing certification's information.
     *
     * @param string $id The certification ID
     * @param UpdateDto $dto The updated certification data
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If certification not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function update(string $id, UpdateDto $dto)
    {
        $certification = $this->certification->findOrFail($id);
        $this->canUpdate($certification);
        $certification->update([
            'name' => $dto->name,
            'description' => $dto->description,
            'date' => $dto->date,
            'url' => $dto->url,
            'id_check' => $dto->id_check,
        ]);
    }

    /**
     * Delete a certification by ID.
     *
     * @param string $id The certification ID
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If certification not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized
     */
    public function delete(string $id)
    {
        $certification = $this->certification->findOrFail($id);
        $this->canDelete($certification);
        $certification->delete();
    }
}
