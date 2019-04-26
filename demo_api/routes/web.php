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

$router->group([
    'middleware' => 'auth'
], function() use($router) {
    $router->get('/users', 'UserController@index');
    $router->get('/users/{id}', 'UserController@show');
    $router->patch('/users/{id}', 'UserController@update');
    $router->post('/users/logout', 'UserController@logout');
    $router->post('/users/{id}/data', 'UserController@data');
    $router->get('/users/{id}/data', 'UserController@getdata');
});

//chat
$router->post('/chat/send', 'ChatController@sendMessage');
$router->post('/chat/listing', 'ChatController@getConversationsList');
$router->post('/chat/history', 'ChatController@getConversationHistory');
$router->post('/chat/status', 'ChatController@checkForUnreadMessages');
$router->post('/chat/status/update', 'ChatController@updateUnreadMessageStatus');

//gathering
$router->post('/gathering', 'GatheringController@createGathering');
$router->post('/gathering/all', 'GatheringController@getGatherings');
$router->post('/gathering/join', 'GatheringController@joinGathering');
$router->get('/gathering/{id}', 'GatheringController@getOneGathering');
$router->post('/gathering/leave', 'GatheringController@leaveGathering');

// survey
$router->get('/survey', 'SurveyController@index');
$router->get('/survey/{id}', 'SurveyController@show');
$router->get('/survey/{id}/category', 'SurveyController@categories');
$router->get('/survey/{id}/finish', 'SurveyController@finish');

$router->get('/survey/category/{id}', 'SurveyController@questions');
$router->post('/survey/category/{id}', 'SurveyController@storeQuestions');

$router->post('/survey/categories/question', 'SurveyController@storeQuestion');
