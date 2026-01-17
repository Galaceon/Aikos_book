<?php
require_once __DIR__ . '/includes/app.php';

use Controllers\AuthController;
use MVC\Router;

$router =  new Router();

// Login
$router->get('/login', [AuthController::class, 'login']);



$router->comprobarRutas();