<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CaisseController;
use App\Controllers\AchatController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', [CaisseController::class, 'index']);
$routes->post('caisse/choisir', [CaisseController::class, 'choisir']);
$routes->get('achats', [AchatController::class, 'index']);
