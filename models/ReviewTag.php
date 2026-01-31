<?php

namespace Model;

class ReviewTag extends ActiveRecord {
    protected static $tabla = 'review_tag';
    protected static $columnasDB = ['review_id', 'tag_id'];

    public $review_id;
    public $tag_id;

    public function __construct($args = [])
    {
        $this->review_id = $args['review_id'] ?? '';
        $this->tag_id = $args['tag_id'] ?? '';
    }

    public static function crearTagReview($reviewId, $tagId) {
        $query = "INSERT INTO review_tag (review_id, tag_id)
                  VALUES ('{$reviewId}', '{$tagId}')";
        return ActiveRecord::$db->query($query);
    }

    public static function eliminarTagReview($reviewId) {
        $query = "DELETE FROM review_tag WHERE review_id = '{$reviewId}'";
        return ActiveRecord::$db->query($query);
    }
}