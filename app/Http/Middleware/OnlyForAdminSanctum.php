<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class OnlyForAdminSanctum
{
    public function handle(Request $request, Closure $next)
    {
        // Пример: включать Sanctum только если путь начинается с /admin-api
        if (str_starts_with($request->path(), 'admin-api/')) {
            return app(EnsureFrontendRequestsAreStateful::class)->handle($request, $next);
        }

        return $next($request); // все остальные запросы работают как обычно
    }
}
