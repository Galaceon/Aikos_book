<?php

namespace Model;

class Tag extends ActiveRecord {
    protected static $tabla = 'tags';
    protected static $columnasDB = ['id', 'name', 'slug'];

    public $id;
    public $name;
    public $slug;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->slug = $args['slug'] ?? '';
    }

    
    public function validar() {
        if(!$this->name) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
    }
    public function crearSlug() {
        $slug = strtolower($this->name);
        $slug = trim($slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);

        $this->slug = $slug;
    }

    public static function tagsPorReview($reviewId) {
        $query = "
            SELECT t.id, t.name
            FROM tags t
            INNER JOIN review_tag rt ON rt.tag_id = t.id
            WHERE rt.review_id = {$reviewId}
        ";

        return self::consultarSQL($query);
    }
}