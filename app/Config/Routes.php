<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CaisseController;
use App\Controllers\AchatController;
use App\Controllers\AuthController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', [AuthController::class, 'index']);
$routes->post('/login', [AuthController::class, 'login']);
$routes->get('/caisse', [CaisseController::class, 'index']);
$routes->post('caisse/choisir', [CaisseController::class, 'choisir']);
$routes->get('achats', [AchatController::class, 'index']);
$routes->post('achats/cloturer', [AchatController::class, 'cloturer']);
$routes->post('achat/cloturer', [AchatController::class, 'cloturer']);
