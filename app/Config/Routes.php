<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('/rokDetail/(:num)', 'Main::rokDetail/$1');
$routes->get('/zavodDetail/(:num)', 'Main::zavodDetail/$1');
$routes->post('zavody/create', 'Main::create');
