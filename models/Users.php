<?php

namespace Model;

class Users extends ActiveRecord {
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'surname', 'email', 'confirmed', 'created_at', 'description', 'image'];

    public $id;
    public $name;
    public $surname;
    public $email;
    public $confirmed;
    public $created_at;
    public $description;
    public $image;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->confirmed = $args['confirmed'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
        $this->description = $args['$description'] ?? '';
        $this->image = $args['$image'] ?? '';
    }

    public function validarPerfil() {
        if(!$this->description || strlen($this->description) < 1) {
            self::$alertas['error'][] = 'La descripción es Obligatoria';
        }
        if(strlen($this->description) >= 120) {
            self::$alertas['error'][] = 'La descripción solo puede contener 120 caracteres';
        }

        return self::$alertas;
    }
}