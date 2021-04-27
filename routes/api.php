<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::match(['get', 'post', 'option'], '/', 'HomeController@index')->name("public.index");

Route::post('login', 'AuthController@login')->name("public.login");
Route::post('register', 'AuthController@register')->name("public.register");
Route::post('verify-email', 'AuthController@verifyEmail')->name("public.verify");

Route::post('send-reset-password-link', 'AuthController@sendResetPasswordLink')->name("public.reset-password");
Route::post('confirm-reset-password-link', 'AuthController@confirmResetPassword')->name("public.confirm-password");


// Require Authentication for these endpoints
Route::middleware(['auth:api'])->group(function () {
        Route::get('/logout', 'AuthController@logout')->name("auth.logout");
        Route::get('/me', 'UsersController@index')->name("auth.user_show");

        Route::group(
            ['prefix' => 'users'],
            function ($router) {

                $router->get('/', 'UsersController@index')->name("auth.api_users_index");
                $router->post('/', 'UsersController@store')->name("auth.api_users_store");
                $router->get('/me', 'UsersController@me')->name("auth.api_users_me");

                $router->get('/{id}', 'UsersController@show')->name("auth.api_users_show");
                $router->put('/{id}', 'UsersController@update')->name("auth.api_users_update");
                $router->delete('/{id}', 'UsersController@destroy')->name("auth.api_users_delete");
            }
        );
        Route::group(
            ['prefix' => 'roles'],
            function ($router) {
                $router->get('/', 'RolesController@index')->name("auth.api_roles_index");
                $router->get('/permissions', 'RolesController@all_permissions')->name("auth.api_roles_permissions");

                $router->get('/{id}', 'RolesController@show')->name("auth.api_roles_show");
                $router->get('/{id}/permissions', 'RolesController@show_permissions')->name("auth.api_role_permissions_show");
                $router->put('/{id}', 'RolesController@update')->name("auth.api_roles_update");
                $router->delete('/{id}', 'RolesController@destroy')->name("auth.api_roles_delete");
            }
        );
        Route::group(
            ['prefix' => 'permissions'],
            function ($router) {
                $router->get('/', 'PermissionsController@index')->name("auth.api_permissions_index");
                $router->post('/', 'PermissionsController@store')->name("auth.api_permissions_store");
                $router->get('/{id}', 'PermissionsController@show')->name("auth.api_permissions_show");
                $router->delete('/{id}', 'PermissionsController@destroy')->name("auth.api_permissions_delete");
            }
        );
        Route::group(
            ['prefix' => 'settings'],
            function ($router) {
                $router->get('/', 'SettingsController@index')->name("auth.api_settings_index");
                $router->post('/', 'SettingsController@update')->name("auth.api_settings_update");
                $router->get('/{id}', 'SettingsController@show')->name("auth.api_settings_show");
                $router->delete('/{id}', 'SettingsController@destroy')->name("auth.api_settings_delete");
            }
        );
        Route::group(
            ['prefix' => 'countries'],
            function ($router) {
                $router->get('/', 'CountriesController@index')->name("auth.api_countries_index");
                $router->get('/{id}', 'CountriesController@show')->name("auth.api_countries_show");
                $router->put('/{id}', 'CountriesController@update')->name("auth.api_countries_update");
                $router->delete('/{id}', 'CountriesController@destroy')->name("auth.api_countries_delete");
            }
        );
        Route::group(
            ['prefix' => 'timezones'],
            function ($router) {
                $router->get('/', 'TimezonesController@index')->name("auth.api_timezones_index");
                $router->get('/{id}', 'TimezonesController@show')->name("auth.api_timezones_show");
                $router->put('/{id}', 'TimezonesController@update')->name("auth.api_timezones_update");
                $router->delete('/{id}', 'TimezonesController@destroy')->name("auth.api_timezones_delete");
            }
        );
        Route::group(
            ['prefix' => 'languages'],
            function ($router) {
                $router->get('/', 'LanguagesController@index')->name("auth.api_languages_index");
                $router->get('/{id}', 'LanguagesController@show')->name("auth.api_languages_show");
                $router->put('/{id}', 'LanguagesController@update')->name("auth.api_languages_update");
                $router->delete('/{id}', 'LanguagesController@destroy')->name("auth.api_languages_delete");
            }
        );
    }
);

Route::addRoute(['GET', 'POST', 'PUT', 'DELETE'], "{fallbackPlaceholder}", 'HomeController@fallback')->where('fallbackPlaceholder', '.*')->name('hidden.fallback.404')->fallback();
