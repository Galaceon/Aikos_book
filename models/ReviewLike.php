<?php

namespace Model;

class ReviewLike extends ActiveRecord {
    protected static $tabla = 'reviews_likes';
    protected static $columnasDB = ['review_id', 'user_id'];

    public $review_id;
    public $user_id;

    public function __construct($args = []) {
        $this->review_id = $args['review_id'] ?? null;
        $this->user_id = $args['user_id'] ?? null;
    }

    public static function like($user_id, $review_id) {
        $query = "
            INSERT IGNORE INTO reviews_likes (user_id, review_id)
            VALUES ($user_id, $review_id)
        ";
        return self::$db->query($query);
    }

    public static function unlike($user_id, $review_id) {
        $query = "
            DELETE FROM reviews_likes
            WHERE user_id = $user_id AND review_id = $review_id
        ";
        return self::$db->query($query);
    }

    public static function exists($user_id, $review_id) {
        $query = "
            SELECT 1 FROM reviews_likes
            WHERE user_id = $user_id AND review_id = $review_id
            LIMIT 1
        ";
        $resultado = self::$db->query($query);
        return $resultado->num_rows > 0;
    }

    public static function countByReview($review_id) {
        $query = "
            SELECT COUNT(*) as total
            FROM reviews_likes
            WHERE review_id = $review_id
        ";
        $resultado = self::$db->query($query);
        $row = $resultado->fetch_assoc();
        return (int) $row['total'];
    }
}