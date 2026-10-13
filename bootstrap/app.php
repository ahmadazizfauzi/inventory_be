<?php

use App\Http\Middleware\CheckRole;
use App\Support\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Standardize validation error responses
        $exceptions->render(function (ValidationException $e, Request $request) {
            return ApiResponse::validationError(
                $e->validator->errors()->messages(),
                'Data yang dikirimkan tidak valid.'
            );
        });

        // Standardize unauthenticated responses
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return ApiResponse::unauthorized('Tidak terautentikasi atau sesi token telah kedaluwarsa.');
        });

        // Standardize 403 forbidden responses
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            return ApiResponse::forbidden($e->getMessage() ?: 'Akses ditolak. Anda tidak memiliki izin untuk tindakan ini.');
        });

        // Standardize 404 not found responses
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return ApiResponse::notFound('Data atau endpoint tidak ditemukan.');
        });

        // Catch other HTTP or server errors in API
        $exceptions->render(function (Throwable $e, Request $request) {
            if (! $request->is('api/*') || app()->hasDebugModeEnabled()) {
                return null;
            }

            $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;
            $message = $status === 404 ? 'Data tidak ditemukan.' : 'Terjadi kesalahan internal pada server.';

            return ApiResponse::success(null, $message, $status);
        });
    })->create();
