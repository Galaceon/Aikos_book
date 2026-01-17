<?php

namespace Model;

class User extends ActiveRecord {
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'surname', 'email', 'password', 'confirmed', 'token', 'admin', 'created_at', 'image'];

    public $id;
    public $name;
    public $surname;
    public $email;
    public $password;
    public $password2;
    public $confirmed;
    public $token;
    public $admin;
    public $created_at;
    public $image;

    public $password_current;
    public $password_new;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->created_at = $args['created_at'] ?? '';
        $this->image = $args['image'] ?? '';
    }
}