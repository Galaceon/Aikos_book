<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Author;
use MVC\Router;

class AuthorsController {


    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/authors?page=1');
        }
        $registros_por_pagina = 9;
        $total = Author::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/authors?page=1');
        }

        $authors = Author::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/authors/index', [
            'titulo' => 'Autores',
            'authors' => $authors,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function create(Router $router) {


        $router->render('admin/authors/create', [
            'titulo' => 'Añadir Autor'
        ]);
    }

    public static function edit(Router $router) {


        $router->render('admin/authors/edit', [
            'titulo' => 'Añadir Autor'
        ]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $author = Author::find($id);

            if(!isset($author)) {
                header('Location: /admin/authors');
            }

            $resultado  = $author->eliminar();

            if($resultado) {
                header('Location: /admin/authors');
            }
        }
    }
}