<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    public const SUPER_ADMIN = '/superadmin';
    public const ADMIN = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        $this->routes(function () {
            Route::prefix('api/v2')
                ->middleware('api')
                ->namespace($this->namespace . '\Api\v2')
                ->group(base_path('routes/api/auth.php'));
            Route::prefix('api/v2')
                ->middleware('api')
                ->namespace($this->namespace . '\Api\v2')
                ->group(base_path('routes/api/utility.php'));
            Route::prefix('api/v2')
                ->middleware('api')
                ->namespace($this->namespace . '\Api\v2')
                ->group(base_path('routes/api/event.php'));
            Route::prefix('api/v2')
                ->middleware('api')
                ->namespace($this->namespace . '\Api\v2')
                ->group(base_path('routes/api/modeltest.php'));
            Route::prefix('api/v2')
                ->middleware('api')
                ->namespace($this->namespace . '\Api\v2')
                ->group(base_path('routes/api/profile.php'));
            Route::middleware('web')->group(base_path('routes/web.php'));
        });
    }
}

