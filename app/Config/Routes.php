<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['GET', 'POST'], 'register', 'Auth::register');
$routes->match(['GET', 'POST'], 'login', 'Auth::login');
