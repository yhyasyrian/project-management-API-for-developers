<?php

namespace App\Providers;

use App\Models\{User, Experience, Project};
use App\Policies\{UserPolicy, ExperiencePolicy, ProjectPolicy};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Route::pattern('id', '[0-9]+');
    }
}
