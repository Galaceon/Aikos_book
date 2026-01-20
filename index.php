<?php
require_once __DIR__ . '/includes/app.php';

use Controllers\AuthController;
use MVC\Router;

$router =  new Router();

// AUTH
$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->get('/forget', [AuthController::class, 'forget']);
$router->get('/confirm', [AuthController::class, 'confirm']);
$router->get('/restore', [AuthController::class, 'restore']);
$router->get('/message', [AuthController::class, 'message']);



$router->comprobarRutas();