<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Project;
use App\Traits\AuthorizationTrait;

/**
 * TagService handles all tag-related business logic including
 * CRUD operations and authorization checks for tags associated with projects.
 */
class TagService
{
    use AuthorizationTrait;

    /**
     * TagService constructor.
     *
     * @param Tag $tag The Tag model instance
     */
    public function __construct(
        private Tag $tag
    ) {
    }

    /**
     * Create multiple tags for a project.
     *
     * @param Project $project The project to associate tags with
     * @param array<string> $data Array of tag names to create
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the project
     */
    public function create(Project $project, array $data): void
    {
        $this->canUpdate($project);
        $project->tags()->createMany(
            array_map(fn($tag) => ['name' => $tag], $data)
        );
    }

    /**
     * Update an existing tag's name.
     *
     * @param Project $project The associated project
     * @param Tag $tag The tag to update
     * @param string $name The new name for the tag
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the project
     */
    public function update(Project $project, Tag $tag, string $name): void
    {
        $this->canUpdate($project);
        $tag->update(['name' => $name]);
    }

    /**
     * Delete a specific tag or all tags for a project.
     *
     * @param Project $project The associated project
     * @param Tag|null $tag The specific tag to delete (null to delete all project tags)
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the project
     */
    public function delete(Project $project, ?Tag $tag = null): void
    {
        $this->canUpdate($project);
        if (is_null($tag)) {
            $project->tags()->delete();
        } else {
            $tag->delete();
        }
    }
}
