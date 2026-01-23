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

        $alertas = [];
        $author = new Author;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author->sincronizar($_POST);
            

            $alertas = $author->validar();
            

            if(empty($alertas)) {
                $author->crearSlug();

                $resultado = $author->guardar();

                if($resultado) {
                    header('Location: /admin/authors');
                }
            }
        }

        

        $router->render('admin/authors/create', [
            'titulo' => 'Añadir Autor',
            'alertas' => $alertas,
            'author' => $author
        ]);
    }

    public static function edit(Router $router) {
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) header('Location: /admin/authors');

        $author = Author::find($id);
        if(!$author) header('Location: /admin/authors');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author->sincronizar($_POST);

            $alertas = $author->validar();

            if(empty($alertas)) {
                $author->crearSlug();

                $resultado = $author->guardar();

                if($resultado) {
                    header('Location: /admin/authors');
                }
            }
        }

        $router->render('admin/authors/edit', [
            'titulo' => 'Editar Autor',
            'author' => $author,
            'alertas' => $alertas
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