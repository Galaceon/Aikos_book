<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Author;
use Model\Review;
use Model\Tag;
use MVC\Router;

class PagesController {


    public static function index(Router $router) {

        $reviews = [];
        $paginacionHTML = '';

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
            'paginacion' => $paginacionHTML
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
}