<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureDashboardAccess;
use App\Http\Middleware\EnsurePermissionAccess;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/dashboard.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'dashboard.access' => EnsureDashboardAccess::class,
            'permission.access' => EnsurePermissionAccess::class,
        ]);

        $middleware->redirectUsersTo(function (Illuminate\Http\Request $request) {
            $user = $request->user();

            if ($user && ($user->isAdmin() || $user->hasPermission('dashboard.access'))) {
                return route('admin.dashboard');
            }

            return route('user.home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
