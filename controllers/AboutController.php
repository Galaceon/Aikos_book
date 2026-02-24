<?php

namespace Controllers;

use MVC\Router;

class AboutController {
    
    public static function index(Router $router) {

        
        $router->render('pages/about', [
            'titulo' => "SOBRE MÍ"
        ]);
    }
    
}
