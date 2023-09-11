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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'client.credentials'], function () use ($router) {
    // Rutas del controlador de Autores
    $router->get('/authors', 'AuthorController@index');
    $router->post('/authors', 'AuthorController@store');
    $router->get('/authors/{author}', 'AuthorController@show');
    $router->put('/authors/{author}', 'AuthorController@update');
    $router->patch('/authors/{author}', 'AuthorController@update');
    $router->delete('/authors/{author}', 'AuthorController@destroy');

    // Rutas del controlador de Libros
    $router->get('/books', 'BookController@index');
    $router->post('/books', 'BookController@store');
    $router->get('/books/{book}', 'BookController@show');
    $router->put('/books/{book}', 'BookController@update');
    $router->patch('/books/{book}', 'BookController@update');
    $router->delete('/books/{book}', 'BookController@destroy');

    // Rutas del controlador de Usuarios
    $router->get('/users', 'UserController@index');
    $router->post('/users', 'UserController@store');
    $router->get('/users/{user}', 'UserController@show');
    $router->put('/users/{user}', 'UserController@update');
    $router->patch('/users/{user}', 'UserController@update');
    $router->delete('/users/{user}', 'UserController@destroy');
});

/**
 * Rutas protegidas por credenciales de usuario
 */
$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('/users/me', 'UserController@me');
});
