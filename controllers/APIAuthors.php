<?php

namespace Controllers;

use Model\Author;

class APIAuthors {

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

        $authors = Author::startsWith('name', $search, 6);

        echo json_encode($authors);
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

            $authorDB = Author::where('name', $name);

            if(empty($authorDB)) {
                $author = new Author;

                $author->name = $name;
                $author->crearSlug();

                $author->guardar();

                $author = Author::where('slug', $author->slug);

                $respuesta = [
                    'id' => $author->id,
                    'name' => $author->name
                ];

                echo json_encode($respuesta);
            } else {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ese autor ya esta registrado'
                ];

                echo json_encode($respuesta);
            }
        }
    }

    public static function all() {
        $authors = Author::orderBy('name');

        echo json_encode(array_map(fn($author) => [
            'id' => $author->id,
            'name' => $author->name,
            'slug' => $author->slug
        ], $authors));
    }
}