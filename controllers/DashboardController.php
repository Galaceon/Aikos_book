<?php

namespace Controllers;


use Model\Author;
use Model\Comment;
use Model\PagesCounter;
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
        if(!is_auth()) {
            header('Location: /');
            exit;
        }

        $alertas = [];

        // Últimos 5 usuarios
        $ultimosUsuarios = User::get(5);

        // Totales
        $totalReviews = Review::total();
        $totalLikes = ReviewLike::total();
        $totalAutores = Author::total();
        $totalComments = Comment::total();
        $allPages = PagesCounter::find('1');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /');
                exit;
            }

            $allPages->sincronizar($_POST);

            $alertas = $allPages->validarPages();
            $alertas = $allPages::getAlertas();

            if(empty($alertas)) {

                $resultado = $allPages->guardar();

                if($resultado) {
                    header('Location: /admin/dashboard');
                }
            }
        }

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'ultimosUsuarios' => $ultimosUsuarios,
            'totalReviews' => $totalReviews,
            'totalLikes' => $totalLikes,
            'totalAutores' => $totalAutores,
            'totalComments' => $totalComments,
            'allPages' => $allPages->total_pages,
            'alertas' => $alertas
        ]);
    }
}