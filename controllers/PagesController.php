<?php

namespace Controllers;

use MVC\Router;

class PagesController {


    public static function index(Router $router) {

        debuguear($_SESSION);

        $router->render('pages/index', [
            'titulo' => 'Aikos Book'
        ]);
    }
}