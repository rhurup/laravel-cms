<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAuthRoutes();

        $this->mapAdminRoutes();
        $this->mapCustomAdminRoutes();

        $this->mapWebRoutes();
        $this->mapCustomWebRoutes();

        $this->mapApiRoutes();
        $this->mapCustomApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::domain(env("ADMIN_DOMAIN", 'admin.example.com'))
            ->middleware(['web'])
            ->namespace($this->namespace .'\Admin')
            ->group(base_path('routes/admin.php'));
    }
    /**
     * Define the custom "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapCustomAdminRoutes()
    {
        if(file_exists(base_path('routes/custom_admin.php'))){
            Route::domain(env("ADMIN_DOMAIN", 'admin.example.com'))
                 ->middleware(['web'])
                 ->namespace($this->namespace .'\Admin')
                 ->group(base_path('routes/custom_admin.php'));
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::domain(env("APP_DOMAIN", 'example.com'))
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
        if(file_exists(base_path('routes/custom_web.php'))){
            Route::domain(env("APP_DOMAIN", 'example.com'))
                 ->middleware('web')
                 ->namespace($this->namespace)
                 ->group(base_path('routes/custom_web.php'));
        }
    }
    /**
     * Define the custom "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapCustomWebRoutes()
    {
        if(file_exists(base_path('routes/custom_web.php'))){
            Route::domain(env("APP_DOMAIN", 'example.com'))
                 ->middleware('web')
                 ->namespace($this->namespace)
                 ->group(base_path('routes/custom_web.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::domain(env("API_DOMAIN", 'api.example.com'))
            ->middleware('api')
            ->namespace($this->namespace .'\Api')
            ->group(base_path('routes/api.php'));
    }
    /**
     * Define the custom "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCustomApiRoutes()
    {
        if(file_exists(base_path('routes/custom_api.php'))) {
            Route::domain(env("API_DOMAIN", 'api.example.com'))
                 ->middleware('api')
                 ->namespace($this->namespace . '\Api')
                 ->group(base_path('routes/custom_api.php'));
        }
    }
    /**
     * Define the auth routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        if(file_exists(base_path('routes/auth.php'))) {
            Route::middleware(['web','guest'])->group(base_path('routes/auth.php'));
        }
    }
}
