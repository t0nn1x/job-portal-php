<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->post('/listings', 'ListingController@store', ['auth']);
$router->get('/listings/create', 'ListingController@create', ['auth']);
$router->get('/listings/{id}/edit', 'ListingController@edit', ['auth']);
$router->put('/listings/{id}', 'ListingController@update', ['auth']);
$router->get('/listings/{id}', 'ListingController@show');
$router->delete('/listings/{id}', 'ListingController@destroy', ['auth']);

$router->get('/auth/register', 'UserController@create');
$router->get('/auth/login', 'UserController@login');
$router->post('/auth/register', 'UserController@store');
$router->post('/auth/logout', 'UserController@logout');
$router->post('/auth/login', 'UserController@authenticate');
