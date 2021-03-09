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
Route::match(['get', 'post', 'option'], '/', 'HomeController@index')->name("admin.public");

Route::middleware(['auth'])->group(function () {
    Route::match(['get', 'post', 'option'], '/home', 'HomeController@home')->name("admin.home");
    Route::get( '/settings', 'SettingsController@index')->name("admin.index");

    Route::get('/users', 'UsersController@index')->name("admin.users");
    Route::get('/users/{id}', 'UsersController@show')->name("admin.users_show");

    Route::get('/roles', 'RolesController@index')->name("admin.roles");
    Route::get('/roles/{id}', 'RolesController@show')->name("admin.roles_show");

    Route::get('/countries', 'CountriesController@index')->name("admin.countries");
    Route::get('/countries/{id}', 'CountriesController@show')->name("admin.countries_show");

    Route::get('/languages', 'LanguagesController@index')->name("admin.languages");
    Route::get('/languages/{id}', 'LanguagesController@show')->name("admin.languages_show");

    Route::get('/timezones', 'TimezonesController@index')->name("admin.timezones");
    Route::get('/timezones/{id}', 'TimezonesController@show')->name("admin.timezones_show");

    Route::get('/information', 'InformationController@index')->name("admin.information");

});
Auth::routes(['register' => false]);