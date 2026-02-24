<?php

namespace Controllers;


use Model\Author;
use Model\Comment;
use Model\Review;
use Model\ReviewLike;
use Model\User;
use MVC\Router;

class DashboardController {


    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        // Últimos 5 usuarios
        $ultimosUsuarios = User::get(5);

        // Totales
        $totalReviews = Review::total();
        $totalLikes = ReviewLike::total();
        $totalAutores = Author::total();
        $totalComments = Comment::total();

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'ultimosUsuarios' => $ultimosUsuarios,
            'totalReviews' => $totalReviews,
            'totalLikes' => $totalLikes,
            'totalAutores' => $totalAutores,
            'totalComments' => $totalComments
        ]);
    }
}