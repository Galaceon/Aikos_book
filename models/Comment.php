<?php
namespace Model;

class Comment extends ActiveRecord {

    protected static $tabla = 'comments';
    protected static $columnasDB = [
        'id',
        'content',
        'user_id',
        'review_id',
        'parent_id',
        'created_at'
    ];

    public $id;
    public $content;
    public $user_id;
    public $review_id;
    public $parent_id;
    public $created_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->content = $args['content'] ?? '';
        $this->user_id = $args['user_id'] ?? null;
        $this->review_id = $args['review_id'] ?? null;
        $this->parent_id = $args['parent_id'] ?? null;
        $this->created_at = $args['created_at'] ?? null;
    }

    public static function comentariosPrincipales($review_id) {

        $review_id = self::$db->escape_string($review_id);

        $query = "
            SELECT * FROM " . static::$tabla . "
            WHERE review_id = '{$review_id}'
            AND parent_id IS NULL
            ORDER BY created_at ASC
        ";

        return self::consultarSQL($query);
    }

    public static function respuestas($parent_id) {

        $parent_id = self::$db->escape_string($parent_id);

        $query = "
            SELECT * FROM " . static::$tabla . "
            WHERE parent_id = '{$parent_id}'
            ORDER BY created_at ASC
        ";

        return self::consultarSQL($query);
    }

    public static function countByReview($review_id) {

        $review_id = self::$db->escape_string($review_id);

        $query = "
            SELECT COUNT(*) as total
            FROM " . static::$tabla . "
            WHERE review_id = '{$review_id}'
        ";

        $resultado = self::$db->query($query);
        $data = $resultado->fetch_assoc();

        return (int) $data['total'];
    }
    public function validar() {

        // Limpiar espacios
        $this->content = trim($this->content);

        if(!$this->content) {
            self::$alertas['error'][] = 'El comentario no puede estar vacío.';
        }

        if(strlen($this->content) < 3) {
            self::$alertas['error'][] = 'El comentario es demasiado corto.';
        }

        if(strlen($this->content) > 3000) {
            self::$alertas['error'][] = 'El comentario no puede superar los 3000 caracteres.';
        }

        if(!$this->review_id || !filter_var($this->review_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'La reseña no es válida.';
        }

        if($this->parent_id !== null && $this->parent_id !== '') {
            if(!filter_var($this->parent_id, FILTER_VALIDATE_INT)) {
                self::$alertas['error'][] = 'Respuesta inválida.';
            }
        }
        if($this->parent_id) {

            $comentarioPadre = self::find($this->parent_id);

            if(!$comentarioPadre || $comentarioPadre->review_id != $this->review_id) {
                self::$alertas['error'][] = 'La respuesta no pertenece a esta reseña.';
            }
        }

        return self::$alertas;
    }
}