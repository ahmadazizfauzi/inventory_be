<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponse
{
    // Standard successful response
    public static function success(mixed $data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    // 201 Created response
    public static function created(mixed $data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return self::success($data, $message, 201);
    }

    // 200 OK paginated response with rich metadata
    public static function paginated(LengthAwarePaginator $paginator, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return response()->json([
            'status_code' => 200,
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'total_pages' => $paginator->lastPage(),
                'has_next_page' => $paginator->hasMorePages(),
                'has_prev_page' => $paginator->currentPage() > 1,
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
            ],
        ], 200);
    }

    // 400 Bad request response
    public static function badRequest(string $message = 'Bad Request', mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status_code' => 400,
            'message' => $message,
            'errors' => $errors,
        ], 400);
    }

    // 401 Unauthorized response
    public static function unauthorized(string $message = 'Unauthenticated or token has expired'): JsonResponse
    {
        return response()->json([
            'status_code' => 401,
            'message' => $message,
        ], 401);
    }

    // 403 Forbidden response
    public static function forbidden(string $message = 'Forbidden. You do not have permission'): JsonResponse
    {
        return response()->json([
            'status_code' => 403,
            'message' => $message,
        ], 403);
    }

    // 404 Not found response
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'status_code' => 404,
            'message' => $message,
        ], 404);
    }

    // 422 Validation error response
    public static function validationError(mixed $errors, string $message = 'The given data was invalid'): JsonResponse
    {
        return response()->json([
            'status_code' => 422,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    // 500 Internal server error response
    public static function serverError(string $message = 'Internal server error'): JsonResponse
    {
        return response()->json([
            'status_code' => 500,
            'message' => $message,
        ], 500);
    }
}
