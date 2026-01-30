<?php

namespace Model;

class Review extends ActiveRecord {
    protected static $tabla = 'reviews';
    protected static $columnasDB = ['id', 'title', 'content', 'rating', 'image', 'created_at', 'admin_id', 'slug'];

    public $id;
    public $title;
    public $content;
    public $rating;
    public $image;
    public $created_at;
    public $admin_id;
    public $slug;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->content = $args['content'] ?? 'abcde';
        $this->rating = $args['rating'] ?? 0;
        $this->image = $args['image'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
        $this->admin_id = $args['admin_id'] ?? 0;
        $this->slug = $args['slug'] ?? '';
    }


    public function validar() {
        if (!$this->title) {
            self::$alertas['error'][] = 'El Título es obligatorio';
        }
        if ($this->rating === '' || $this->rating === null) {
            self::$alertas['error'][] = 'La puntuación es obligatoria';
            return self::$alertas;
        }
        if (!is_numeric($this->rating)) {
            self::$alertas['error'][] = 'La puntuación debe ser un número';
            return self::$alertas;
        }
        $rating = floatval($this->rating);
        if ($rating < 0 || $rating > 10) {
            self::$alertas['error'][] = 'La valoración debe estar entre 0 y 10';
        }
        if(!$this->image) {
            self::$alertas['error'][] = 'La Imagen es Obligatoria';
        }
        if(!$this->content) {
            self::$alertas['error'][] = 'La Reseña es Obligatoria';
        }
    }

    public function crearSlug() {
        $slug = strtolower($this->title);
        $slug = trim($slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);

        $this->slug = $slug;
    }
}