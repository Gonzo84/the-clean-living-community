<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// user
$router->post('/users', 'UserController@store');

$router->post('/reset_password_request', 'UserController@resetPasswordRequest');
$router->post('/reset_password', 'UserController@resetPassword');

$router->group([
    'middleware' => 'client.credentials'
], function() use($router) {
    $router->get('/users', 'UserController@index');
    $router->get('/users/{id}', 'UserController@show');
    $router->patch('/users/{id}', 'UserController@update');
});
