<?php

namespace Controllers;

use MVC\Router;

class UsersController {


    public static function index(Router $router) {


        $router->render('admin/users/index', [
            'titulo' => 'Autores'
        ]);
    }
}