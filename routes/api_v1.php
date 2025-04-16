<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactInformationController;

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
