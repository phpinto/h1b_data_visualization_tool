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

Route::get('/', function () {
    return view('welcome');
});

// Socialite Routes:

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider', function ($provider) {
    return $provider;
})->where('provider', 'facebook|linkedin');

Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback', function ($provider) {
    return $provider;
})->where('provider', 'facebook|linkedin');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@index')->name('home');
