<?php

namespace App\Http\Middleware;

use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // Ensure authenticated user has one of the required roles
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return ApiResponse::unauthorized();
        }

        if (! in_array($user->role, $roles, true)) {
            return ApiResponse::forbidden('Akses ditolak. Anda tidak memiliki izin untuk tindakan ini.');
        }

        return $next($request);
    }
}
