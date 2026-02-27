<?php

namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Author;
use Model\Comment;
use Model\Review;
use Model\ReviewLike;
use Model\ReviewSaved;
use Model\Tag;
use Model\Users;
use MVC\Router;

class PagesController {


    public static function index(Router $router) {
        $reviews = [];
        $paginacionHTML = '';

        $likedReviews = [];
        $likesCount = [];
        $commentsCount = [];
        $savedReviews = [];

        $user = null;

        if(is_auth()) {
            $user = Users::find($_SESSION['id']);
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /?page=1');
        }
        $registros_por_pagina = 12;

        $tag = $_GET['tag'] ?? null;
        $author = $_GET['author'] ?? null;

        $filtros = [
            'tag' => $tag,
            'author' => $author
        ];

        if ($tag || $author) {
            $total = Review::totalFiltrado($filtros);
        } else {
            $total = Review::total();
        }

        if($total > 0) {
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

            if($paginacion->total_paginas() < $pagina_actual) {
                header('Location: /?page=1');
            }

            if ($tag || $author) {
                $reviews = Review::filtrarPaginado(
                    $filtros,
                    $registros_por_pagina,
                    $paginacion->offset()
                );
            } else {
                $reviews = Review::paginar(
                    $registros_por_pagina,
                    $paginacion->offset()
                );
            }

            $paginacionHTML = $paginacion->paginacion();
        }

        

        foreach($reviews as $review) {
            $likesCount[$review->id] = ReviewLike::countByReview($review->id);

            $commentsCount[$review->id] = Comment::countByReview($review->id);

            if(is_auth()) {
                $likedReviews[$review->id] = ReviewLike::exists(
                    $_SESSION['id'],
                    $review->id
                );
            } else {
                $likedReviews[$review->id] = false;
            }
        }

        if(is_auth()) {
            foreach($reviews as $review) {
                $savedReviews[$review->id] = ReviewSaved::exists(
                    $_SESSION['id'],
                    $review->id
                );
            }
        }
        $router->render('pages/index', [
            'titulo' => "Últimas Reseñas",
            'reviews' => $reviews,
            'paginacion' => $paginacionHTML,
            'user' => $user,
            'likesCount' => $likesCount,
            'likedReviews' => $likedReviews,
            'savedReviews' => $savedReviews,
            'commentsCount' => $commentsCount
        ]);
    }

    public static function review(Router $router) {
        $slug = $_GET['slug'];
        if(!$slug) header('Location: /');

        $review = Review::findBySlug($slug);
        if(!$review) header('Location: /');

        $review->imagen_actual = $review->image;

        $reviewTags = Tag::relacionados('review_tag', 'tag_id', 'review_id', $review->id);
        $reviewAuthors = Author::relacionados('review_author', 'author_id', 'review_id', $review->id);

        $admin = Users::where('id', $review->admin_id);

        $reviewAnterior = Review::anterior($review->created_at);
        $reviewSiguiente = Review::siguiente($review->created_at);

        // 🔹 Obtener comentarios principales
        $comentarios = Comment::comentariosPrincipales($review->id);

        foreach($comentarios as $comentario) {

            // 🔹 Añadir usuario al comentario
            $comentario->usuario = Users::find($comentario->user_id);

            // 🔹 Obtener respuestas
            $comentario->respuestas = Comment::respuestas($comentario->id);

            // 🔹 Añadir usuario a cada respuesta
            foreach($comentario->respuestas as $respuesta) {
                $respuesta->usuario = Users::find($respuesta->user_id);
            }
        }

        $router->render('pages/review', [
            'titulo' => "Aiko's Book",
            'review' => $review,
            'reviewTags' => $reviewTags,
            'reviewAuthors' => $reviewAuthors,
            'admin' => $admin,
            'reviewAnterior' => $reviewAnterior,
            'reviewSiguiente' => $reviewSiguiente,
            'comentarios' => $comentarios
        ]);
    }



    public static function profile(Router $router) {
        if(!is_auth()) {
            header('Location: /');
            exit;
        }
        $alertas = [];

        $user = Users::find($_SESSION['id']);
        if(empty($user)) {
            header('Location: /');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_FILES['avatar']['tmp_name'])) {
                $carpeta_imagenes = PUBLIC_PATH . '/img/users';

                if($_FILES['avatar']['size'] > 6 * 1024 * 1024) {
                    Users::setAlerta('error', 'La imagen no puede superar los 6MB');
                }

                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_webp = Image::make($_FILES['avatar']['tmp_name'])
                    ->fit(400,400)
                    ->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['image'] = $nombre_imagen;
            }

            if($user->description === $_POST['description'] && !isset($_POST['image'])) {
                Users::setAlerta('error', 'Debes cambiar algo en tu perfil para guardar cambios');
            }
            
            $user->sincronizar($_POST);
            $alertas = $user->validarPerfil();
            $alertas = Users::getAlertas();

            if(empty($alertas)) {
                
                if(isset($nombre_imagen)) {
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }

                $resultado = $user->guardar();

                if($resultado) {
                    header('Location: /profile');
                }
            }
        }

        $router->render('pages/profile', [
            'titulo' => "Perfil de Usuario",
            'user' => $user,
            'alertas' => $alertas
        ]);
    }


    public static function saved(Router $router) {
        $reviews = [];
        $paginacionHTML = '';

        $likedReviews = [];
        $likesCount = [];
        $savedReviews = [];


        $user = Users::find($_SESSION['id']);

        if(empty($user)) {
            header('Location: /');
            exit;
        }

        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /saved?page=1');
            exit;
        }

        $registros_por_pagina = 12;
        $total = ReviewSaved::total();

        if($total > 0) {
            $totalSaved = ReviewSaved::totalByUser($_SESSION['id']);

            $paginacion = new Paginacion(
                $pagina_actual,
                $registros_por_pagina,
                $totalSaved
            );

            if($paginacion->total_paginas() < $pagina_actual) {
                header('Location: /saved?page=1');
                exit;
            }

            $reviews = ReviewSaved::savedByUser(
                $_SESSION['id'],
                $registros_por_pagina,
                $paginacion->offset()
            );

            $paginacionHTML = $paginacion->paginacion();
        }

        foreach($reviews as $review) {
            $savedReviews[$review->id] = ReviewSaved::exists(
                $_SESSION['id'],
                $review->id
            );
        }

        foreach($reviews as $review) {
            $likesCount[$review->id] = ReviewLike::countByReview($review->id);

            if(is_auth()) {
                $likedReviews[$review->id] = ReviewLike::exists(
                    $_SESSION['id'],
                    $review->id
                );
            } else {
                $likedReviews[$review->id] = false;
            }
        }

        $router->render('pages/saved', [
            'titulo' => "Reseñas Guardadas",
            'reviews' => $reviews,
            'paginacion' => $paginacionHTML,
            'user' => $user,
            'likesCount' => $likesCount,
            'likedReviews' => $likedReviews,
            'savedReviews' => $savedReviews
        ]);
    }
}