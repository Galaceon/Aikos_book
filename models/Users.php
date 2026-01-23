<?php

namespace Model;

class Users extends ActiveRecord {
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'surname', 'email', 'confirmed', 'created_at'];

    public $id;
    public $name;
    public $surname;
    public $email;
    public $confirmed;
    public $created_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->confirmed = $args['confirmed'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
    }
}