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
}