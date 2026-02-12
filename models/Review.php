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
            self::$alertas['error'][] = 'La Imagen es Obligatoria no es Válida, busca otra';
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

    public static function anterior($created_at) {
        $created_at = self::$db->escape_string($created_at);

        $query = "
            SELECT * FROM reviews
            WHERE created_at < '{$created_at}'
            ORDER BY created_at DESC
            LIMIT 1
        ";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function siguiente($created_at) {
        $created_at = self::$db->escape_string($created_at);

        $query = "
            SELECT * FROM reviews
            WHERE created_at > '{$created_at}'
            ORDER BY created_at ASC
            LIMIT 1
        ";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function totalFiltrado($filtros = []) {
        $tag = $filtros['tag'] ?? null;
        $author = $filtros['author'] ?? null;

        $joins = [];
        $wheres = [];

        if ($tag) {
            $joins[] = "INNER JOIN review_tag rt ON rt.review_id = reviews.id";
            $joins[] = "INNER JOIN tags t ON t.id = rt.tag_id";
            $wheres[] = "t.slug = '" . self::$db->escape_string($tag) . "'";
        }

        if ($author) {
            $joins[] = "INNER JOIN review_author ra ON ra.review_id = reviews.id";
            $joins[] = "INNER JOIN authors a ON a.id = ra.author_id";
            $wheres[] = "a.slug = '" . self::$db->escape_string($author) . "'";
        }

        $query = "SELECT COUNT(DISTINCT reviews.id) as total FROM reviews ";

        if (!empty($joins)) {
            $query .= implode(' ', $joins);
        }

        if (!empty($wheres)) {
            $query .= " WHERE " . implode(' AND ', $wheres);
        }

        $resultado = self::$db->query($query);
        $row = $resultado->fetch_assoc();

        return $row['total'] ?? 0;
    }

    public static function filtrarPaginado($filtros = [], $limit, $offset) {
        $tag = $filtros['tag'] ?? null;
        $author = $filtros['author'] ?? null;

        $joins = [];
        $wheres = [];

        if ($tag) {
            $joins[] = "INNER JOIN review_tag rt ON rt.review_id = reviews.id";
            $joins[] = "INNER JOIN tags t ON t.id = rt.tag_id";
            $wheres[] = "t.slug = '" . self::$db->escape_string($tag) . "'";
        }

        if ($author) {
            $joins[] = "INNER JOIN review_author ra ON ra.review_id = reviews.id";
            $joins[] = "INNER JOIN authors a ON a.id = ra.author_id";
            $wheres[] = "a.slug = '" . self::$db->escape_string($author) . "'";
        }

        $query = "SELECT DISTINCT reviews.* FROM reviews ";

        if (!empty($joins)) {
            $query .= implode(' ', $joins);
        }

        if (!empty($wheres)) {
            $query .= " WHERE " . implode(' AND ', $wheres);
        }

        $query .= " ORDER BY reviews.created_at DESC";
        $query .= " LIMIT " . intval($limit);
        $query .= " OFFSET " . intval($offset);

        return self::consultarSQL($query);
    }
}