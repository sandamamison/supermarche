<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('achat', 'Achat::index');
$routes->post('achat/ajouter', 'Achat::ajouter');
$routes->post('achat/cloturer', 'Achat::cloturer');

// Route temporaire pour tester si la page choix de caisse n'est pas encore faite
$routes->get('test-caisse/(:num)', 'Achat::testCaisse/$1');