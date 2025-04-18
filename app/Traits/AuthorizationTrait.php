<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Enums\AuthorizationActionEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * AuthorizationTrait provides methods for handling authorization checks
 *
 * This trait contains methods that verify if the authenticated user has
 * permission to perform specific actions on models. It uses Laravel's
 * authorization system and the AuthorizationActionEnum to define actions.
 */
trait AuthorizationTrait
{
    /**
     * Check if user is authorized to perform an action on a model
     *
     * @param AuthorizationActionEnum $action The action to check authorization for
     * @param Model|string|null $model The model or model class to check authorization against
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Throws 403 if unauthorized
     */
    protected function can(AuthorizationActionEnum $action, $model = null)
    {
        Gate::authorize($action->value, $model);
    }

    /**
     * Check if user can view any instances of a model
     *
     * @param Model|string $model The model or model class to check authorization against
     */
    protected function canViewAny(Model|string $model)
    {
        $this->can(AuthorizationActionEnum::VIEW_ANY, $model);
    }

    /**
     * Check if user can view a specific model instance
     *
     * @param Model $model The model instance to check authorization against
     */
    protected function canView(Model $model)
    {
        $this->can(AuthorizationActionEnum::VIEW, $model);
    }

    /**
     * Check if user can create new instances of a model
     */
    protected function canCreate(Model|string $model)
    {
        $this->can(AuthorizationActionEnum::CREATE, $model);
    }

    /**
     * Check if user can update a specific model instance
     *
     * @param Model $model The model instance to check authorization against
     */
    protected function canUpdate(Model $model)
    {
        $this->can(AuthorizationActionEnum::UPDATE, $model);
    }

    /**
     * Check if user can delete a specific model instance
     *
     * @param Model $model The model instance to check authorization against
     */
    protected function canDelete(Model $model)
    {
        $this->can(AuthorizationActionEnum::DELETE, $model);
    }
}