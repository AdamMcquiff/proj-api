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
    $api->group([
        'namespace' => 'App\Http\Auth\Controllers'
    ], function ($api) {
        $api->post('register', 'AuthenticationController@register');
        $api->post('authenticate', 'AuthenticationController@authenticate');
        $api->post('password/email', 'ForgotPasswordController@resetPassword');
        $api->post('password/reset', 'ResetPasswordController@reset');
    });

    $api->group([
        'middleware' => 'api.auth',
        'namespace' => 'App\Http'
    ], function ($api) {
        $api->resource('organisations', 'Users\Controllers\OrganisationController');
        $api->post('organisations/join/{organisation}', 'Users\Controllers\OrganisationController@join');
    });
});