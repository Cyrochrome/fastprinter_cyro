<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/fetch', 'Home::fetchRawData');
$routes->post('/', 'Home::createProduct');
$routes->put('/(:segment)', 'Home::updateProduct/$1');
$routes->delete('/(:segment)', 'Home::deleteProduct/$1');
