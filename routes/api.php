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
        'namespace' => 'App\Http'
    ], function ($api) {
        $api->post('invitation/project', 'Projects\Controllers\ProjectController@acceptInvitation');
        $api->post('invitation/team', 'Users\Controllers\TeamController@acceptInvitation');
    });

    $api->group([
        'middleware' => 'api.auth',
        'namespace' => 'App\Http'
    ], function ($api) {
        $api->get('profile', 'Auth\Controllers\AuthenticationController@getProfile');
        $api->post('profile', 'Auth\Controllers\AuthenticationController@updateProfile');

        $api->resource('organisations', 'Users\Controllers\OrganisationController');
        $api->post('organisations/join/{organisation}', 'Users\Controllers\OrganisationController@join');

        $api->resource('teams', 'Users\Controllers\TeamController');
        $api->post('teams/{id}/invite', 'Users\Controllers\TeamController@invite');

        $api->resource('projects', 'Projects\Controllers\ProjectController');
        $api->post('projects/{id}/invite', 'Projects\Controllers\ProjectController@invite');
        $api->post('projects/{id}/archive', 'Projects\Controllers\ProjectController@archive');

        $api->resource('iterations', 'Projects\Controllers\IterationController');
        $api->resource('tasks', 'Projects\Controllers\TaskController');

        $api->get('search/{terms}', 'Projects\Controllers\SearchController@search');

        $api->resource('clients', 'Clients\Controllers\ClientController');
    });
});