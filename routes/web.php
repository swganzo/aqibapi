<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'map'], function () {
  Route::any('all', 'SensorController@mapAll');
  Route::any('single', 'SensorController@mapSingle');
});

Route::group(['middleware' => 'auth'], function(){
  // Sensor routes
  Route::get('sensors','SensorController@index');
  Route::group(['prefix' => 'sensor'], function () {
    Route::any('{action?}/{id?}', 'SensorController@main');
  });
});
