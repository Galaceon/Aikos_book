<?php

namespace Model;

class PagesCounter extends ActiveRecord {
    protected static $tabla = 'pages_counter';
    protected static $columnasDB = ['id', 'total_pages'];

    public $id;
    public $total_pages;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->total_pages = $args['total_pages'] ?? '';
    }

    
    public function validarPages() {
        if($this->total_pages === '' || $this->total_pages === null) {
            self::$alertas['error'][] = 'El total de páginas no puede estar vacío.';
            return;
        }

        if(!is_numeric($this->total_pages)) {
            self::$alertas['error'][] = 'El total de páginas debe ser un número válido.';
            return;
        }
        
        $this->total_pages = (int) $this->total_pages;
        if($this->total_pages < 0) {
            self::$alertas['error'][] = 'El total de páginas no puede ser un número negativo.';
        }

        $actual = self::find(1); // Como solo tienes un registro
        if($actual && $this->total_pages === (int) $actual->total_pages) {
            self::$alertas['error'][] = 'El nuevo valor es igual al actual. No se realizaron cambios.';
        }

        return self::$alertas;
    }
}