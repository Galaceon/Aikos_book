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

            $datos = [
                'content' => $_POST['content'] ?? '',
                'review_id' => $_POST['review_id'] ?? null,
                'parent_id' => $_POST['parent_id'] ?? null
            ];

            $comment = new Comment($datos);

            $comment->user_id = $_SESSION['id'];
            $comment->created_at = date('Y-m-d H:i:s');

            if(empty($comment->parent_id)) {
                $comment->parent_id = null;
            }

            $alertas = $comment->validar();

            if(empty($alertas['error'])) {

                $resultado = $comment->guardar();

                if($resultado) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }

            $_SESSION['alertas'] = $alertas;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}