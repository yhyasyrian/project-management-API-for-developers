<?php

namespace App\Http\Controllers;

use App\Models\{Tag, Project};
use App\Services\{TagService, ApiResponseService};
use Illuminate\Routing\Controllers\{Middleware, HasMiddleware};
use App\Http\Requests\Tags\{CreateRequest, UpdateRequest};

/**
 * TagController handles all tag-related operations for projects including
 * creating, updating, and deleting tags.
 */
class TagController extends Controller implements HasMiddleware
{
    /**
     * TagController constructor.
     *
     * @param TagService $tagService The service handling tag-related business logic
     */
    public function __construct(
        private TagService $tagService
    ) {
    }

    /**
     * Create new tags for a project.
     *
     * @param CreateRequest $request The validated request containing tag data
     * @param Project $project The project to associate tags with
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function store(CreateRequest $request, Project $project)
    {
        $this->tagService->create($project, $request->all());
        return ApiResponseService::success([]);
    }

    /**
     * Update an existing tag's name.
     *
     * @param UpdateRequest $request The validated request containing new tag name
     * @param Project $project The associated project
     * @param Tag $tag The tag to update
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function update(UpdateRequest $request, Project $project, Tag $tag)
    {
        $this->tagService->update($project, $tag, $request->get('name'));
        return ApiResponseService::success([]);
    }

    /**
     * Delete a specific tag or all tags for a project.
     *
     * @param Project $project The associated project
     * @param Tag|null $tag The specific tag to delete (null to delete all project tags)
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "data": []
     * }
     */
    public function destroy(Project $project, ?Tag $tag = null)
    {
        $this->tagService->delete($project, $tag);
        return ApiResponseService::success([]);
    }

    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
        ];
    }
}
