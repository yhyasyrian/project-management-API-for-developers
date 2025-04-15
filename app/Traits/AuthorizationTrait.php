<?php

namespace App\Traits;

use App\Enums\AuthorizationActionEnum;
use Illuminate\Database\Eloquent\Model;

trait AuthorizationTrait
{
    protected function can(AuthorizationActionEnum $action, $model = null)
    {
        if (auth()->check() && auth()->user()->can($action->value, $model)) {
            return;
        }
        abort(403, 'Unauthorized');
    }
    protected function canViewAny(Model|string $model)
    {
        $this->can(AuthorizationActionEnum::VIEW_ANY, $model);
    }
    protected function canView(Model $model)
    {
        $this->can(AuthorizationActionEnum::VIEW, $model);
    }
    protected function canCreate()
    {
        $this->can(AuthorizationActionEnum::CREATE);
    }
    protected function canUpdate(Model $model)
    {
        $this->can(AuthorizationActionEnum::UPDATE, $model);
    }
    protected function canDelete(Model $model)
    {
        $this->can(AuthorizationActionEnum::DELETE, $model);
    }
}