<?php

namespace Controllers;

use MVC\Router;

class TagsController {


    public static function index(Router $router) {


        $router->render('admin/tags/index', [
            'titulo' => 'Tags'
        ]);
    }
}