<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'api'], function () use ($router) {
    //users
    $router->post('/user', ['uses' => 'UserController@create']);
    $router->get('/token', ['uses' => 'UserController@authenticate']);

    //locations
    $router->post('/locations', ['uses' => 'LocationsController@create']);
    $router->get('/locations/{id}', ['uses' => 'LocationsController@get']);
    $router->delete('/locations/{id}', ['uses' => 'LocationsController@delete']);
});
