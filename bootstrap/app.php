<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            // Helper function to streamline route grouping
            $configureRoute = function ($prefix, $name, $path, $middleware = ['web', 'auth:admin', SetLocale::class]) {
                Route::middleware($middleware)
                    ->prefix($prefix)
                    ->name($name)
                    ->group(base_path($path));
            };

            Route::middleware('web')->group(base_path('routes/web.php'));

            // Admin routes
            $configureRoute('dashboard/admin', 'dashboard.admin.', 'routes/dashboard/admin/web.php');
            $configureRoute('dashboard/admin/websites', 'dashboard.admin.websites.', 'routes/dashboard/admin/website.php');
            $configureRoute('dashboard/admin/managements', 'dashboard.admin.managements.', 'routes/dashboard/admin/management.php');
            $configureRoute('dashboard/admin/settings', 'dashboard.admin.settings.', 'routes/dashboard/admin/setting.php');
            $configureRoute('dashboard/admin', 'dashboard.admin.auth.', 'routes/dashboard/admin/auth.php', ['web', SetLocale::class]);
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Applying global middleware and guest redirection
        $middleware->append([
            \App\Http\Middleware\SetLocale::class
        ])->redirectGuestsTo(fn ($request) =>
            in_array('auth:admin', $request->route()->middleware()) ? route('dashboard.admin.auth.login.index') : ''
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling configuration, if needed
    })->create();