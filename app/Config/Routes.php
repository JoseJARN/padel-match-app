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
// Eliminar, modificar y actualizar partidos
$routes->get('/matches/edit/(:num)', 'Matches::edit/$1');
$routes->post('/matches/edit/(:num)', 'Matches::update/$1');
$routes->get('/matches/delete/(:num)', 'Matches::delete/$1');
$routes->get('logout', 'Auth::logout');
