<?php

namespace Controllers;

use Model\ReviewLike;

class APILikes {

    public static function toggle() {
        $review_id = filter_var($_POST['review_id'], FILTER_VALIDATE_INT);

        if(!is_auth()) {
            http_response_code(401);
            echo json_encode([
                'redirect' => '/login'
            ]);
            return;
        }

        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Método inválido']);
            return;
        }

        
        $user_id = $_SESSION['id'];

        if(!$review_id) {
            echo json_encode(['error' => 'ID inválido']);
            return;
        }

        if(ReviewLike::exists($user_id, $review_id)) {
            ReviewLike::unlike($user_id, $review_id);
            $liked = false;
        } else {
            ReviewLike::like($user_id, $review_id);
            $liked = true;
        }

        $total = ReviewLike::countByReview($review_id);

        echo json_encode([
            'liked' => $liked,
            'total' => $total
        ]);
    }
}