<?php

namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Author;
use Model\Review;
use Model\ReviewAuthor;
use Model\ReviewTag;
use Model\Tag;
use MVC\Router;

class ReviewsController {


    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/reviews?page=1');
        }
        $registros_por_pagina = 9;
        $total = Review::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        $reviews = Review::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/reviews/index', [
            'titulo' => 'Usuarios Registrados',
            'reviews' => $reviews,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        $review = new Review;
        $tags = new Tag;
        $authors = new Author;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /');
                exit;
            }

            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = PUBLIC_PATH . '/img/reviews';

                if($_FILES['imagen']['size'] > 5 * 1024 * 1024) {
                    Review::setAlerta('error', 'La imagen no puede superar los 5MB');
                }

                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['image'] = $nombre_imagen;
            }
            
            $review->sincronizar($_POST);

            $reviewDB = Review::where('title' ,$review->title);
            if(!empty($reviewDB)) {
                $alertas = Review::setAlerta('error', 'No puedes repetir un título, escribe uno diferente');
            }

            $alertas = $review->validar();
            $alertas = Review::getAlertas();

            if(empty($alertas)) {

                if(isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }

                $review->created_at = date('Y-m-d H:i:s');
                $review->crearSlug();
                $review->admin_id = $_SESSION['admin'];

                $resultado = $review->guardar();

                $review = Review::where('slug', $review->slug);

                if(!empty($_POST['tags'])) {
                    
                    $tags = json_decode($_POST['tags'], true);

                    foreach($tags as $tag_id) {
                        ReviewTag::crearTagReview($review->id, $tag_id);
                    }
                }
                if(!empty($_POST['authors'])) {
                    $authors = json_decode($_POST['authors'], true);

                    foreach($authors as $author_id) {
                        ReviewAuthor::crearAuthorReview($review->id, $author_id);
                    }
                }

                if($resultado) {
                    header('Location: /admin/reviews');
                }
            }
        }

        $router->render('admin/reviews/create', [
            'titulo' => 'Crea una nueva reseña.',
            'alertas' => $alertas,
            'review' => $review,
            'tags' => $tags,
            'authors' => $authors
        ]);
    }

    public static function edit(Router $router) {
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) header('Location: /admin/reviews');

        $review = Review::find($id);
        $review->imagen_actual = $review->image;
        if(!$review) header('Location: /admin/reviws');


        $reviewTags = Tag::relacionados('review_tag', 'tag_id', 'review_id', $review ->id);
        $reviewAuthors = Author::relacionados('review_author', 'author_id', 'review_id', $review ->id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /');
                exit;
            }

            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = PUBLIC_PATH . '/img/reviews';

                if($_FILES['imagen']['size'] > 5 * 1024 * 1024) {
                    Review::setAlerta('error', 'La imagen no puede superar los 5MB');
                }

                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['image'] = $nombre_imagen;
            }
            
            $review->sincronizar($_POST);

            $alertas = $review->validar();
            $alertas = Review::getAlertas();

            if(empty($alertas)) {

                if(isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }

                $review->crearSlug();

                $resultado = $review->guardar();

                $review = Review::where('slug', $review->slug);

                if(!empty($_POST['tags'])) {
                    $tags = json_decode($_POST['tags'], true);

                    ReviewTag::eliminarTagReview($review->id);

                    foreach($tags as $tag_id) {
                        ReviewTag::crearTagReview($review->id, $tag_id);
                    }
                }
                if(!empty($_POST['authors'])) {
                    $authors = json_decode($_POST['authors'], true);

                    ReviewAuthor::eliminarAuthorReview($review->id);

                    foreach($authors as $author_id) {
                        ReviewAuthor::crearAuthorReview($review->id, $author_id);
                    }
                }

                if($resultado) {
                    header('Location: /admin/reviews');
                }
            }
        }

        $router->render('admin/reviews/edit', [
            'titulo' => 'Editar Publicación',
            'review' => $review,
            'alertas' => $alertas,
            'reviewTags' => $reviewTags,
            'reviewAuthors' => $reviewAuthors
        ]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $reviews = Review::find($id);

            if(!isset($reviews)) {
                header('Location: /admin/reviewss');
            }

            $resultado  = $reviews->eliminar();

            if($resultado) {
                header('Location: /admin/reviews');
            }
        }
    }
}