<?php
require_once __DIR__ . '/includes/app.php';

use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\PagesController;
use MVC\Router;

$router =  new Router();

// AUTH
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/forget', [AuthController::class, 'forget']);
$router->post('/forget', [AuthController::class, 'forget']);

$router->get('/confirm', [AuthController::class, 'confirm']);

$router->get('/restore', [AuthController::class, 'restore']);
$router->post('/restore', [AuthController::class, 'restore']);

$router->get('/message', [AuthController::class, 'message']);


// PAGES
$router->get('/', [PagesController::class, 'index']);



// ADMIN
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/reviews', [DashboardController::class, 'index']);


$router->comprobarRutas();