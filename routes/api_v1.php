<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

Route::apiResource('/project', ProjectController::class);

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware(['throttle:5,3']);
    Route::post('register', [AuthController::class, 'register'])->middleware(['auth:api', 'throttle:5,3']);
});
