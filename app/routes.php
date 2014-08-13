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
    $string = 'kaka';

    dd(substr($string, 0 , 1));
});


Route::get('/s3/{bucket}/{identifier}/{operations}/{path}', array('uses' => 'S3ImageController@process'))->where('path', '.*');

Route::resource('api/config', 'ImageConfigController');