<?php

namespace Model;

class ReviewSaved extends ActiveRecord {
    protected static $tabla = 'reviews_saved';
    protected static $columnasDB = ['user_id', 'review_id', 'created_at'];

    public $user_id;
    public $review_id;
    public $created_at;

    public function __construct($args = [])
    {
        $this->user_id = $args['user_id'] ?? '';
        $this->review_id = $args['review_id'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
    }

     public static function save($user_id, $review_id) {
        $query = "
            INSERT IGNORE INTO reviews_saved (user_id, review_id)
            VALUES ($user_id, $review_id)
        ";
        return self::$db->query($query);
    }

    public static function quit($user_id, $review_id) {
        $query = "
            DELETE FROM reviews_saved
            WHERE user_id = $user_id AND review_id = $review_id
        ";
        return self::$db->query($query);
    }

    public static function exists($user_id, $review_id) {
        $query = "
            SELECT 1 FROM reviews_saved
            WHERE user_id = $user_id AND review_id = $review_id
            LIMIT 1
        ";
        $resultado = self::$db->query($query);
        return $resultado->num_rows > 0;
    }

    public static function savedByUser($user_id) {
        $query = "
            SELECT r.*
            FROM reviews_saved rs
            JOIN reviews r ON rs.review_id = r.id
            WHERE rs.user_id = $user_id
            ORDER BY rs.created_at DESC
        ";
        return Review::consultarSQL($query);
    }
}