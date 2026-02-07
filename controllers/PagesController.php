<?php

namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Author;
use Model\Review;
use Model\Tag;
use Model\Users;
use MVC\Router;

class PagesController {


    public static function index(Router $router) {

        $reviews = [];
        $paginacionHTML = '';
        $user = Users::find($_SESSION['id']);
        if(empty($user)) {
            $user = '';
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /?page=1');
        }
        $registros_por_pagina = 12;
        $total = Review::total();

        if($total > 0) {
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

            if($paginacion->total_paginas() < $pagina_actual) {
                header('Location: /admin/ponentes?page=1');
            }

            $reviews = Review::paginar($registros_por_pagina, $paginacion->offset());

            $paginacionHTML = $paginacion->paginacion();
        }

        $router->render('pages/index', [
            'titulo' => "Aiko's Book",
            'reviews' => $reviews,
            'paginacion' => $paginacionHTML,
            'user' => $user
        ]);
    }

    public static function review(Router $router) {

        $slug = $_GET['slug'];
        if(!$slug) header('Location: /');

        $review = Review::findBySlug($slug);
        $review->imagen_actual = $review->image;
        if(!$review) header('Location: /admin/reviws');


        $reviewTags = Tag::relacionados('review_tag', 'tag_id', 'review_id', $review ->id);
        $reviewAuthors = Author::relacionados('review_author', 'author_id', 'review_id', $review ->id);

        
        $router->render('pages/review', [
            'titulo' => "Aiko's Book",
            'review' => $review,
            'reviewTags' => $reviewTags,
            'reviewAuthors' => $reviewAuthors
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
                Users::setAlerta('error', 'Debes cambiar algo en tu perfil para guarfar cambios');
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
}