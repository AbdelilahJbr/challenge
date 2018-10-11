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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router) {

	$router->post('login',  ['uses' => 'UserController@login']);

	$router->get('users',  [ 'uses' => 'UserController@showAllUsers']);

	$router->get('users/{id}', ['uses' => 'UserController@showOneUser']);

	$router->post('users', ['uses' => 'UserController@create']);

	$router->delete('users/{id}', ['middleware' => 'auth', 'uses' => 'UserController@delete']);

	$router->put('users/{id}', ['middleware' => 'auth', 'uses' => 'UserController@update']);

	$router->get('users/liked/{id}', ['middleware' => 'auth', 'uses' => 'UserController@showUserLikedShops']);
	$router->get('users/disliked/{id}', ['middleware' => 'auth', 'uses' => 'UserController@showUserLislikedShops']);

	$router->post('users/liked/{id}/{shop_id}', ['middleware' => 'auth', 'uses' => 'UserController@addLiked']);
	$router->post('users/disliked/{id}/{shop_id}', ['middleware' => 'auth', 'uses' => 'UserController@addDisliked']);

	$router->delete('users/liked/{id}', ['middleware' => 'auth', 'uses' => 'UserController@deleteLiked']);
	$router->delete('users/disliked/{id}', ['middleware' => 'auth', 'uses' => 'UserController@deleteDisliked']);

	
});