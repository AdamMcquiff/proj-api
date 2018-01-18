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

use App\Http\Controllers\AuthenticationController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('authenticate', 'AuthenticationController@login');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        //
    });
});