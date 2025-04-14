<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Services\ApiResponseService;
use App\Http\Requests\Project\CreateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProjectController extends Controller implements HasMiddleware
{
    public function __construct(private ProjectService $projectService){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        return ApiResponseService::success(['projects'=>$this->projectService->getAllProjects($page)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        return ApiResponseService::success([]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public static function Middleware(): array
    {
        return [
            // new Middleware('auth:api',only:['store']),
        ];
    }
}
