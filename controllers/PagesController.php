<?php

namespace Controllers;

use Model\Review;
use MVC\Router;

class PagesController {


    public static function index(Router $router) {

        $reviews = Review::all('DESC');


        $router->render('pages/index', [
            'titulo' => "Aiko's Book",
            'reviews' => $reviews
        ]);
    }
}