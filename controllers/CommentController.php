<?php

namespace Controllers;

use Model\Comment;

class CommentController {

    public static function create() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /');
                exit;
            }
            
            $comment = new Comment($_POST);
            if(empty($comment->parent_id)) {
                $comment->parent_id = null;
            }
            $comment->user_id = $_SESSION['id'];
            $comment->created_at = date('Y-m-d H:i:s');

            $alertas = $comment->validar();

            if(empty($alertas['error'])) {

                $resultado = $comment->guardar();

                if($resultado) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
        }
    }
}