<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('admin')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\HandleUserToken::class);

        // Для API роутов
        $middleware->alias([
            'throttle.api' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
        ]);

        $middleware->group('api', [
            'throttle.api:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->group('admin', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'auth:sanctum',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

//        $middleware->api(prepend: [
//            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
//        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Server Error',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        });
    })
    ->create();

