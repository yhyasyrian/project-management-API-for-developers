<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\Projects\CreateDto;
use App\DTOs\Projects\UpdateDto;
use App\Services\ProjectService;
use App\Services\ApiResponseService;
use App\Http\Requests\Projects\CreateRequest;
use App\Http\Requests\Projects\UpdateRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProjectController extends Controller implements HasMiddleware
{
    public function __construct(private ProjectService $projectService)
    {
    }

    /**
     * Get a paginated list of all projects.
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
     *       "content": "string",
     *       "price": "string",
     *       "domain": "string",
     *       "status": "success",
     *       "start_at": "2025-04-17T18:22:25.444Z",
     *       "end_at": "2025-04-17T18:22:25.444Z"
     *     }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        return ApiResponseService::success(
            $this->projectService->getAll($request->query('page', 1))
        );
    }

    /**
     * Create a new project.
     *
     * @param CreateRequest $request The validated request containing project details
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to create projects
     */
    public function store(CreateRequest $request)
    {
        $dto = CreateDto::fromRequest($request);
        $this->projectService->create($dto);
        return ApiResponseService::success([]);
    }

    /**
     * Get details of a specific project.
     *
     * @param string $id The ID of the project to retrieve
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": {
     *     "id": 0,
     *     "name": "string",
     *     "description": "string",
     *     "content": "string",
     *     "price": "string",
     *     "domain": "string",
     *     "status": "success",
     *     "start_at": "2025-04-17T18:25:14.963Z",
     *     "end_at": "2025-04-17T18:25:14.963Z",
     *     "tags": [
     *       {
     *         "id": 0,
     *         "name": "string"
     *       }
     *     ],
     *     "count_tasks": 0,
     *     "client": {
     *       "id": 0,
     *       "name": "string",
     *       "email": "string",
     *       "role": "developer"
     *     }
     *   }
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If project not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to view the project
     */
    public function show(string $id)
    {
        $project = $this->projectService->getById($id);
        return ApiResponseService::success($project);
    }

    /**
     * Update an existing project's information.
     *
     * @param UpdateRequest $request The validated request containing updated project details
     * @param string $id The ID of the project to update
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If project not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the project
     */
    public function update(UpdateRequest $request, string $id)
    {
        $dto = UpdateDto::fromRequest($request);
        $this->projectService->update($id, $dto);
        return ApiResponseService::success([]);
    }

    /**
     * Delete a project.
     *
     * @param string $id The ID of the project to delete
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If project not found
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to delete the project
     */
    public function destroy(string $id)
    {
        $this->projectService->delete($id);
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
