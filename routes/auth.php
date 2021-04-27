<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(env("APP_DOMAIN", 'example.com'))->group(function () {
        Auth::routes();

        if(env("GITHUB_ENABLED", false)) {
            Route::group(
                ['prefix' => 'github'],
                function ($router) {
                    $router->get('/auth/login', 'App\Http\Controllers\SocialiteController@github_login')->name("github-login");
                    $router->get('/auth/redirect', 'App\Http\Controllers\SocialiteController@github_redirect')->name('github-redirect');
                    $router->get('/auth/deletion', 'App\Http\Controllers\SocialiteController@github_deletion')->name('github-deletion');
                }
            );
        }
        if(env("FACEBOOK_ENABLED", false)){
            Route::group(
                ['prefix' => 'facebook'],
                function ($router) {
                    $router->get('/auth/login', 'App\Http\Controllers\SocialiteController@facebook_login')->name('facebook-login');
                    $router->get('/auth/redirect', 'App\Http\Controllers\SocialiteController@facebook_redirect')->name('facebook-redirect');
                    $router->get('/auth/deletion', 'App\Http\Controllers\SocialiteController@facebook_deletion')->name('facebook-deletion');
                }
            );
        }
        if(env("GOOGLE_ENABLED", false)){
            Route::group(
                ['prefix' => 'google'],
                function ($router) {
                    $router->get('/auth/login', 'App\Http\Controllers\SocialiteController@google_login')->name('google-login');
                    $router->get('/auth/redirect', 'App\Http\Controllers\SocialiteController@google_redirect')->name('google-redirect');
                    $router->get('/auth/deletion', 'App\Http\Controllers\SocialiteController@google_deletion')->name('google-deletion');
                }
            );
        }
    }
);

Route::domain(env("ADMIN_DOMAIN", 'admin.example.com'))->middleware(["web"])->group(function () {
        Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name("admin.login");
        Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name("admin.loginpost");
        Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name("admin.logout");
        Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name("admin.password.request");
    }
);
