<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\Certifications\CreateDto;
use App\DTOs\Certifications\UpdateDto;
use App\Services\CertificationService;
use App\Services\ApiResponseService;
use App\Http\Requests\Certifications\CreateRequest;
use App\Http\Requests\Certifications\UpdateRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
/**
 * Controller for managing certifications
 *
 * This controller handles the creation, updating, and deletion of certifications
 * through RESTful endpoints. It utilizes the CertificationService for business logic
 * and enforces authorization checks using the AuthorizationTrait.
 */
class CertificationController extends Controller implements HasMiddleware
{
    public function __construct(private CertificationService $certificationService)
    {
    }

    /**
     * Get a paginated list of all certifications.
     *
     * @param Request $request The HTTP request containing pagination parameters
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 0,
     *       "name": "string",
     *       "description": "string",
     *       "date": "2025-04-17",
     *       "url": "string",
     *       "id_check": "string"
     *     }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        return ApiResponseService::success(
            $this->certificationService->getAll($request->query('page', 1))
        );
    }

    /**
     * Create a new certification.
     *
     * @param CreateRequest $request The validated request containing certification details
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to create certifications
     */
    public function store(CreateRequest $request)
    {
        $dto = CreateDto::fromRequest($request);
        $this->certificationService->create($dto);
        return ApiResponseService::success([]);
    }

    /**
     * Get details of a specific certification.
     *
     * @param string $id The ID of the certification to retrieve
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": {
     *     "id": 0,
     *     "name": "string",
     *     "description": "string",
     *     "date": "2025-04-17",
     *     "url": "string",
     *     "id_check": "string"
     *   }
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If certification not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to view the certification
     */
    public function show(string $id)
    {
        $certification = $this->certificationService->getById($id);
        return ApiResponseService::success($certification);
    }

    /**
     * Update an existing certification's information.
     *
     * @param UpdateRequest $request The validated request containing updated certification details
     * @param string $id The ID of the certification to update
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If certification not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the certification
     */
    public function update(UpdateRequest $request, string $id)
    {
        $dto = UpdateDto::fromRequest($request);
        $this->certificationService->update($id, $dto);
        return ApiResponseService::success([]);
    }

    /**
     * Delete a certification.
     *
     * @param string $id The ID of the certification to delete
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If certification not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to delete the certification
     */
    public function destroy(string $id)
    {
        $this->certificationService->delete($id);
        return ApiResponseService::success([]);
    }

    /**
     * Define middleware for the controller.
     *
     * @return array Array of middleware definitions
     */
    public static function Middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index']),
        ];
    }
}
