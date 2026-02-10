<?php

namespace Controllers;

use Model\Tag;

class APITags {

    public static function index() {
        if(!is_admin()) {
            header('Location: /');
            exit;
        }

        $search = $_GET['search'] ?? '';
        $search = trim($search);

        if(strlen($search) < 1) {
            echo json_encode([]);
            return;
        }

        $tags = Tag::startsWith('name', $search, 6);

        echo json_encode($tags);
    }

    public static function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /');
                exit;
            }

            $name = trim($_POST['name']);

            if(!$name) {
                echo json_encode(['error' => 'Nombre vacío']);
                return;
            }

            $tagDB = Tag::where('name', $name);

            if(empty($tagDB)) {
                $tag = new Tag;

                $tag->name = $name;
                $tag->crearSlug();

                $tag->guardar();

                $tag = Tag::where('slug', $tag->slug);

                $respuesta = [
                    'id' => $tag->id,
                    'name' => $tag->name
                ];

                echo json_encode($respuesta);
            } else {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ese tag ya esta registrado'
                ];

                echo json_encode($respuesta);
            }
        }
    }
}