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
}