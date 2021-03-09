<?php

namespace App\Providers;

use App\Services\ViewService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $isDarkMode = ViewService::isDarkModeVisible();
        $isSidebarVisible = ViewService::isSidebarVisible();

        View::share('isDarkModeVisible', $isDarkMode);
        View::share('isSidebarVisible', $isSidebarVisible);
    }
}
