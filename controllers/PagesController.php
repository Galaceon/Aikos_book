<?php

namespace Controllers;

use MVC\Router;

class PagesController {


    public static function index(Router $router) {


        $router->render('pages/index', [
            'titulo' => 'Aikos Book'
        ]);
    }
}