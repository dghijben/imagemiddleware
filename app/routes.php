<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    dd(App::environment());
});

Route::get('images/url/{name}/{operations}/{created_time}', array('uses' => 'ImageController@process'))->where('cached_unique', '.*');

Route::resource('api/config', 'ImageConfigController');