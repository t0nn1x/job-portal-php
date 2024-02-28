<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->post('/listings', 'ListingController@store');
$router->get('/listings/create', 'ListingController@create');
$router->get('/listings/{id}/edit', 'ListingController@edit');
$router->put('/listings/{id}', 'ListingController@update');
$router->get('/listings/{id}', 'ListingController@show');
$router->delete('/listings/{id}', 'ListingController@destroy');

$router->get('/auth/register', 'UserController@create');
$router->get('/auth/login', 'UserController@login');
$router->post('/auth/register', 'UserController@store');
