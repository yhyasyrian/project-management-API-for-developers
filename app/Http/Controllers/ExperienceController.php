<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\Experiences\CreateDto;
use App\DTOs\Experiences\UpdateDto;
use App\Services\ExperienceService;
use App\Services\ApiResponseService;
use App\Http\Requests\Experiences\CreateRequest;
use App\Http\Requests\Experiences\UpdateRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

/**
 * ExperienceController
 *
 * This controller handles the management of experiences.
 * It provides endpoints for creating, retrieving, updating, and deleting experiences.
 *
*/
class ExperienceController extends Controller implements HasMiddleware
{
    /**
     * Constructor for the ExperienceController.
     *
     * @param ExperienceService $experienceService The service for managing experiences
     */
    public function __construct(private ExperienceService $experienceService)
    {
    }

    /**
     * Get a paginated list of all experiences.
     *
     * @param Request $request The HTTP request containing pagination parameters
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 0,
     *       "name": "string",
     *       "content": "string",
     *       "start_date": "2025-04-17T18:22:25.444Z",
     *       "end_date": "2025-04-17T18:22:25.444Z"
     *     }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        return ApiResponseService::success(
            $this->experienceService->getAll($request->query('page', 1))
        );
    }

    /**
     * Create a new experience.
     *
     * @param CreateRequest $request The validated request containing experience details
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to create experiences
     */
    public function store(CreateRequest $request)
    {
        $dto = CreateDto::fromRequest($request);
        $this->experienceService->create($dto);
        return ApiResponseService::success([]);
    }

    /**
     * Get details of a specific experience.
     *
     * @param string $id The ID of the experience to retrieve
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": {
     *     "id": 0,
     *     "name": "string",
     *     "content": "string",
     *     "start_date": "2025-04-17T18:25:14.963Z",
     *     "end_date": "2025-04-17T18:25:14.963Z"
     *   }
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If experience not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to view the experience
     */
    public function show(string $id)
    {
        $experience = $this->experienceService->getById($id);
        return ApiResponseService::success($experience);
    }

    /**
     * Update an existing experience's information.
     *
     * @param UpdateRequest $request The validated request containing updated experience details
     * @param string $id The ID of the experience to update
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If experience not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the experience
     */
    public function update(UpdateRequest $request, string $id)
    {
        $dto = UpdateDto::fromRequest($request);
        $this->experienceService->update($id, $dto);
        return ApiResponseService::success([]);
    }

    /**
     * Delete an experience.
     *
     * @param string $id The ID of the experience to delete
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If experience not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to delete the experience
     */
    public function destroy(string $id)
    {
        $this->experienceService->delete($id);
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
