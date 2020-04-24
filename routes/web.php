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
Route::get('/get_home_image/{file}', 'WelcomeController@get_image');
Route::get('test_page',  'TestController@index');
Route::get('/heat_map', 'HeatMapController@index');
Route::get('/get_map_json', 'HeatMapController@get_map_json');
Route::get('/get_csv', 'HeatMapController@get_csv');
Route::get('/job_search', 'JobSearchController@index');
Route::get('/return_image/{type}',  'HeatMapController@return_image');
Route::get('/dataviz',  'DataVizController@index');
Route::get('/get_data_image/{file}',  'DataVizController@get_data_image');
Route::get('/top_companies',  'TopCompaniesController@index');
Route::get('/get_top_companies',  'TopCompaniesController@get_top_companies');
Route::get('/getJobs/{job_title?}/{employer?}/{city?}/{state?}/{year?}', 'JobSearchController@get_jobs');
