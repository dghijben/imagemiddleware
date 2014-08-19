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

Route::get('images/s3/{bucket}/{name}/{operations}/{path}', array('uses' => 'S3ImageController@process'))->where('path', '.*');

Route::resource('api/config', 'ImageConfigController');