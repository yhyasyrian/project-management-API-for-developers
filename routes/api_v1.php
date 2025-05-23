<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\{AuthController, UserController};
use App\Http\Controllers\{ProjectController, ExperienceController, CertificationController, ContactInformationController};

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware(['throttle:5,3']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:api']);
});
Route::apiResource('/user', UserController::class)->middleware(['auth:api'])->except(['update']);
Route::patch('/user/{id}', [UserController::class, 'changePassword'])->middleware(['auth:api']);
Route::put('/user/{id}', [UserController::class, 'update'])->middleware(['auth:api']);

Route::apiResource('/user/{user}/contact-information', ContactInformationController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware(['auth:api']);

Route::apiResource('/project', ProjectController::class);
Route::apiResource('/experience', ExperienceController::class)->except(['show']);
Route::apiResource('/certification', CertificationController::class)->except(['show']);
Route::apiResource('/project/{project}/tag', TagController::class)->only(['store', 'update', 'destroy']);
Route::delete('/project/{project}/tag', [TagController::class, 'destroy']);