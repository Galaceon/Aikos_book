<?php

namespace Controllers;

use Model\ReviewSaved;

class APISaved {

    public static function toggle() {

        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        if(!is_auth()) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'No autenticado'
            ]);
            return;
        }

        $user_id = $_SESSION['id'];
        $review_id = filter_var($_POST['review_id'], FILTER_VALIDATE_INT);

        if(!$review_id) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'ID inválido'
            ]);
            return;
        }

        if(ReviewSaved::exists($user_id, $review_id)) {
            ReviewSaved::quit($user_id, $review_id);

            echo json_encode([
                'saved' => false
            ]);
        } else {
            ReviewSaved::save($user_id, $review_id);

            echo json_encode([
                'saved' => true
            ]);
        }
    }

    public static function index() {

        if(!is_auth()) {
            header('Location: /');
            exit;
        }

        $user_id = $_SESSION['id'];

        $reviews = ReviewSaved::savedByUser($user_id);

        echo json_encode($reviews);
    }
}