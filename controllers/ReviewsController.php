<?php

namespace Controllers;

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

        $review = new Review;


        $router->render('admin/reviews/index', [
            'titulo' => 'Gestión de Reseñas',
            'review' => $review
        ]);
    }

    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }
        $review = new Review;
        $tag = new Tag;
        $author = new Author;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /');
                exit;
            }
            

            $review->sincronizar($_POST);

            $review->created_at = date('Y-m-d H:i:s');
            $review->crearSlug();
            $review->admin_id = $_SESSION['admin'];

            $resultado = $review->guardar();

            $review = Review::where('slug', $review->slug);

            if(!empty($_POST['tags'])) {
                
                $tags = json_decode($_POST['tags'], true);

                foreach($tags as $tag_id) {
                    $reviewTag = new ReviewTag([
                        'review_id' => $review->id,
                        'tag_id' => $tag_id
                    ]);

                    $reviewTag->guardar();
                }
            }
            if(!empty($_POST['authors'])) {
                
                $authors = json_decode($_POST['authors'], true);

                foreach($authors as $author_id) {
                    $reviewAuthor = new ReviewAuthor([
                        'review_id' => $review->id,
                        'author_id' => $author_id
                    ]);

                    $reviewAuthor->guardar();
                }
            }

            if($resultado) {
                header('Location: /admin/reviews');
            }
        }

        $router->render('admin/reviews/create', [
            'titulo' => 'Crea una nueva reseña.',
            'alertas' => $alertas,
            'review' => $review,
            'tag' => $tag,
            'author' => $author
        ]);
    }
}