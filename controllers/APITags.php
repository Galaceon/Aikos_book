<?php

namespace Controllers;

use Model\Tag;

class APITags {

    public static function index() {
        $tags = Tag::all();

        echo json_encode($tags);
    }
}