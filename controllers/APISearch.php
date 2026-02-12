<?php

namespace Controllers;

use Model\Review;

class APISearch {
    public static function index() {
        $search = $_GET['search'] ?? '';
        $search = trim($search);

        if(strlen($search) < 1) {
            echo json_encode([]);
            return;
        }

        $reviews = Review::searchLike('title', $search, 6);

        echo json_encode(array_map(fn($review) => [
            'id' => $review->id,
            'title' => $review->title,
            'slug' => $review->slug
        ], $reviews));
    }
}