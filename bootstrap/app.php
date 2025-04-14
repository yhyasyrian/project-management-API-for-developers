<?php

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use App\Exceptions\PublicException;
use App\Services\ApiResponseService;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',

    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponseService::error($e->getMessage(), 401); // unauthorized
            }
        });
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponseService::error($e->getMessage(), 403); // forbidden
            }
        });
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponseService::error($e->getMessage(), 422, $e->errors()); // unprocessable entity
            }
        });
        $exceptions->render(function (PublicException $e, Request $request) {
            if ($request->is('api/*')) {
                return $e->render($request); // internal server error
            }
        });
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponseService::error($e->getMessage(), 429); // too many requests
            }
        });
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponseService::error($e->getMessage(), 500,app()->isLocal() ? ['class'=>$e::class] : []); // internal server error
            }
        });
    })->create();
