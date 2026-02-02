<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Review;
use MVC\Router;

class PagesController {


    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /?page=1');
        }
        $registros_por_pagina = 12;
        $total = Review::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        $reviews = Review::paginar($registros_por_pagina, $paginacion->offset());


        $router->render('pages/index', [
            'titulo' => "Aiko's Book",
            'reviews' => $reviews,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}