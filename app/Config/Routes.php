<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CaisseController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', [CaisseController::class, 'index']);
$routes->post('caisse/choisir', [CaisseController::class, 'choisir']);
$routes->get('achats', [\App\Controllers\AchatController::class, 'index']);
