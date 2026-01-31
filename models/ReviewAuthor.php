<?php

namespace Model;

class ReviewAuthor extends ActiveRecord {
    protected static $tabla = 'review_author';
    protected static $columnasDB = ['review_id', 'author_id'];

    public $review_id;
    public $author_id;

    public function __construct($args = [])
    {
        $this->review_id = $args['review_id'] ?? '';
        $this->author_id = $args['author_id'] ?? '';
    }

    public static function crearAuthorReview($reviewId, $authorId) {
        $query = "INSERT INTO review_author (review_id, author_id)
                  VALUES ('{$reviewId}', '{$authorId}')";
        return ActiveRecord::$db->query($query);
    }

    public static function eliminarAuthorReview($reviewId) {
        $query = "DELETE FROM review_author WHERE review_id = '{$reviewId}'";
        return ActiveRecord::$db->query($query);
    }
}