<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['GET', 'POST'], 'register', 'Auth::register');
$routes->match(['GET', 'POST'], 'login', 'Auth::login');
$routes->get('board', 'Board::index');
$routes->post('board/add', 'Board::add'); // Para manejar el formulario de añadir partidos
$routes->get('matches', 'Matches::index');
$routes->get('logout', 'Auth::logout');
