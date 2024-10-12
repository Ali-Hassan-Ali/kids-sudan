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

            Route::middleware('web', 'auth:admin')
                ->prefix('dashboard/admin')->name('dashboard.admin.')
                ->group(base_path('routes/dashboard/admin/web.php'));

            Route::middleware('web', 'auth:admin')
                ->prefix('dashboard/admin/websites')->name('dashboard.admin.websites.')
                ->group(base_path('routes/dashboard/admin/website.php'));

            Route::middleware('web', 'auth:admin')
                ->prefix('dashboard/admin/managements')->name('dashboard.admin.managements.')
                ->group(base_path('routes/dashboard/admin/management.php'));

            Route::middleware('web')
                ->prefix('dashboard/admin/settings')->name('dashboard.admin.settings.')
                ->group(base_path('routes/dashboard/admin/setting.php'));

            Route::middleware('web')
                ->prefix('dashboard/admin')->name('dashboard.admin.auth.')
                ->group(base_path('routes/dashboard/admin/auth.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->use([
            \App\Http\Middleware\SetLocale::class
        ])->redirectGuestsTo(fn ($request) => 
            in_array('auth:admin', $request->route()->middleware()) ? route('dashboard.admin.auth.login.index') : ''
        );

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
