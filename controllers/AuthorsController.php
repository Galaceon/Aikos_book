<?php

namespace Controllers;

use MVC\Router;

class AuthorsController {


    public static function index(Router $router) {


        $router->render('admin/authors/index', [
            'titulo' => 'Autores'
        ]);
    }
}