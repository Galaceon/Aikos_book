<?php
require_once __DIR__ . '/includes/app.php';

use Controllers\APITags;
use Controllers\AuthController;
use Controllers\AuthorsController;
use Controllers\DashboardController;
use Controllers\PagesController;
use Controllers\ReviewsController;
use Controllers\TagsController;
use Controllers\UsersController;
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



// ADMIN & APIs
// ADMIN
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/reviews', [ReviewsController::class, 'index']);
$router->get('/admin/reviews/create', [ReviewsController::class, 'create']);
$router->post('/admin/reviews/create', [ReviewsController::class, 'create']);
$router->get('/admin/reviews/edit', [ReviewsController::class, 'edit']);
$router->post('/admin/reviews/edit', [ReviewsController::class, 'edit']);
$router->post('/admin/reviews/delete', [ReviewsController::class, 'delete']);

$router->get('/admin/tags', [TagsController::class, 'index']);
$router->get('/admin/tags/create', [TagsController::class, 'create']);
$router->post('/admin/tags/create', [TagsController::class, 'create']);
$router->get('/admin/tags/edit', [TagsController::class, 'edit']);
$router->post('/admin/tags/edit', [TagsController::class, 'edit']);
$router->post('/admin/tags/delete', [TagsController::class, 'delete']);

$router->get('/admin/authors', [AuthorsController::class, 'index']);
$router->get('/admin/authors/create', [AuthorsController::class, 'create']);
$router->post('/admin/authors/create', [AuthorsController::class, 'create']);
$router->get('/admin/authors/edit', [AuthorsController::class, 'edit']);
$router->post('/admin/authors/edit', [AuthorsController::class, 'edit']);
$router->post('/admin/authors/delete', [AuthorsController::class, 'delete']);

$router->get('/admin/users', [UsersController::class, 'index']);
$router->post('/admin/users/delete', [UsersController::class, 'delete']);

// APIs
$router->get('/api/tags', [APITags::class, 'index']);


$router->comprobarRutas();