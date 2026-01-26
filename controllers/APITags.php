<?php

namespace Controllers;

use Model\Tag;

class APITags {

    public static function index() {
        $tags = Tag::all();

        echo json_encode($tags);
    }

    public static function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']);

            if(!$name) {
                echo json_encode(['error' => 'Nombre vacío']);
                return;
            }

            $tag = new Tag;

            $tag->name = $name;
            $tag->crearSlug();

            $tag->guardar();

            $tag = Tag::where('slug', $tag->slug);

            echo json_encode([
                'id' => $tag->id,
                'name' => $tag->name
            ]);
        }
    }


}