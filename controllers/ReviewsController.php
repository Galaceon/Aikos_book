<?php

namespace Controllers;

use MVC\Router;

class ReviewsController {


    public static function index(Router $router) {


        $router->render('admin/reviews/index', [
            'titulo' => 'Aikos Book'
        ]);
    }
}