<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('dashboard/admin')->name('dashboard.admin.')
                ->group(base_path('routes/dashboard/admin/web.php'));

            Route::middleware('web')
                ->prefix('dashboard/admin/management')->name('dashboard.admin.management.')
                ->group(base_path('routes/dashboard/admin/management.php'));

            Route::middleware('web')
                ->prefix('dashboard/admin/setting')->name('dashboard.admin.setting.')
                ->group(base_path('routes/dashboard/admin/setting.php'));

            Route::middleware('web')
                ->prefix('dashboard/admin')->name('dashboard.admin.')
                ->group(base_path('routes/dashboard/admin/auth.php'));

            Route::prefix('api')->name('api.')
                ->group(base_path('routes/api.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
