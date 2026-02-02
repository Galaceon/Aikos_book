<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Tag;
use MVC\Router;

class TagsController {
    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/tags?page=1');
        }
        $registros_por_pagina = 9;
        $total = Tag::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/tags?page=1');
        }

        $tags = Tag::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/tags/index', [
            'titulo' => 'Tags',
            'tags' => $tags,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        $alertas = [];
        $tag = new Tag;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tag->sincronizar($_POST);
            
            $tagDB = Tag::where('name', $tag->name);

            if(!empty($tagDB)) Tag::setAlerta('error', 'Ese Tag ya fue creado');

            $alertas = $tag->validar();
            $alertas = Tag::getAlertas();        

            if(empty($alertas)) {
                $tag->crearSlug();

                $resultado = $tag->guardar();

                if($resultado) {
                    header('Location: /admin/tags');
                }
            }
        }


        $router->render('admin/tags/create', [
            'titulo' => 'Añadir Tag',
            'alertas' => $alertas,
            'tag' => $tag
        ]);
    }

    public static function edit(Router $router) {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) header('Location: /admin/tags');

        $tag = Tag::find($id);
        if(!$tag) header('Location: /admin/tags');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tag->sincronizar($_POST);

            $alertas = $tag->validar();

            if(empty($alertas)) {
                $tag->crearSlug();

                $resultado = $tag->guardar();

                if($resultado) {
                    header('Location: /admin/tags');
                }
            }
        }

        $router->render('admin/tags/edit', [
            'titulo' => 'Editar Tag',
            'tag' => $tag,
            'alertas' => $alertas
        ]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /');
                exit;
            }

            $id = $_POST['id'];

            $tag = Tag::find($id);

            if(!isset($tag)) {
                header('Location: /admin/tags');
            }

            $resultado  = $tag->eliminar();

            if($resultado) {
                header('Location: /admin/tags');
            }
        }
    }
}