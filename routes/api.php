<?php

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('authenticate', 'App\Http\Auth\Controllers\AuthenticationController@authenticate');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        //
    });
});