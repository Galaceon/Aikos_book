<?php

namespace Controllers;

use Model\Author;

class APIAuthors {

    public static function index() {
        $authors = Author::all();


        echo json_encode($authors);
    }

    public static function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
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


}