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
$router->post('/users/login', 'UserController@login');

//$router->post('/password/reset_request', 'UserController@resetPassword');
$router->post('/users/password/reset', 'UserController@resetPassword');

//token
$router->post('/oauth/token', 'Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
$router->post('/oauth/token/refresh', 'Laravel\Passport\Http\Controllers\AccessTokenController@refresh');
$router->get('/oauth/clients', 'Laravel\Passport\Http\Controllers\ClientController@forUser');
$router->delete('/oauth/personal-access-tokens/{token_id}', '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@destroy');

$router->group([
    'middleware' => 'auth'
], function() use($router) {
    $router->get('/users', 'UserController@index');
    $router->get('/users/{id}', 'UserController@show');
    $router->patch('/users/{id}', 'UserController@update');
    $router->post('/users/logout', 'UserController@logout');
});

//chat
$router->post('/chat/send', 'ChatController@sendMessage');
$router->get('/chat/listing', 'ChatController@getConversationsList');
$router->post('/chat/history', 'ChatController@getConversationHistory');




// survey
$router->get('/surveys', 'SurveyController@index');
$router->get('/surveys/{id}', 'SurveyController@show');

$router->get('/survey/category', 'CategoryController@index');
$router->get('/survey/category/{id}', 'CategoryController@show');

$router->get('/survey/categories/{id}', 'CategoryController@getCategorySurvey');
