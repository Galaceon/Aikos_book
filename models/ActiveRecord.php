<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC') {
        $orden = strtoupper($orden);
        $orden = in_array($orden, ['ASC', 'DESC']) ? $orden : 'DESC';

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id) return null;

        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findBySlug(string $slug) {
        $slug = self::$db->escape_string($slug);

        $query = "SELECT * FROM " . static::$tabla . " WHERE slug = '{$slug}' LIMIT 1";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $limite = filter_var($limite, FILTER_VALIDATE_INT);
        if(!$limite || $limite < 1) return [];

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $limite " ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        if(!in_array($columna, static::$columnasDB)) return null;
        $valor = self::$db->escape_string($valor);

        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Retornar los registros con un orden
    public static function ordenar($columna, $orden) {
        if(!in_array($columna, static::$columnasDB)) return [];
        $orden = strtoupper($orden);
        $orden = in_array($orden, ['ASC', 'DESC']) ? $orden : 'ASC';

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Retornar los registros con un orden y con un limite maximo
    public static function ordenarLimite($columna, $orden, $limite) {
        if(!in_array($columna, static::$columnasDB)) return [];
        $orden = strtoupper($orden);
        $orden = in_array($orden, ['ASC', 'DESC']) ? $orden : 'ASC';

        $limite = filter_var($limite, FILTER_VALIDATE_INT);
        if(!$limite || $limite < 1) return [];

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden LIMIT $limite ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Varias Opciones
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            // Validar columna
            if(!in_array($key, static::$columnasDB, true)) {
                continue;
            }

            if($key == array_key_last($array)) {
                $query .= "$key = '$value'";
            } else {
                $query .= "$key = '$value' AND ";
            }
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Paginar los registros
    public static function paginar($por_pagina, $offset) {
        $por_pagina = filter_var($por_pagina, FILTER_VALIDATE_INT);
        $offset = filter_var($offset, FILTER_VALIDATE_INT);

        if($por_pagina < 1 || $offset < 0) return [];

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $por_pagina OFFSET $offset " ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Traer un total de registros
    public static function total($columna = '', $valor = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;

        if ($columna && in_array($columna, static::$columnasDB, true)) {
            $valor = self::$db->escape_string($valor);
            $query .= " WHERE $columna = '$valor'";
        }

        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();

        return array_shift($total);
    }

    // Total de registros con un Array Where
    public static function totalArray($array = []) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";

        foreach($array as $key => $value) {
            if (!in_array($key, static::$columnasDB, true)) {
                continue;
            }
            $value = self::$db->escape_string($value);


            if($key == array_key_last($array)) {
                $query .= "$key = '$value'";
            } else {
                $query .= "$key = '$value' AND ";
            }
        }

        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();

        return array_shift($total);
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        // debuguear($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function relacionados(string $tablaIntermedia, string $fkRelacion, string $fkPrincipal, int $valorPrincipal) {
        $tablaPrincipal = static::$tabla;

        $tablaIntermedia = self::$db->escape_string($tablaIntermedia);
        $fkRelacion = self::$db->escape_string($fkRelacion);
        $fkPrincipal = self::$db->escape_string($fkPrincipal);

        $valorPrincipal = self::$db->escape_string($valorPrincipal);

        $query = "
            SELECT {$tablaPrincipal}.*
            FROM {$tablaPrincipal}
            INNER JOIN {$tablaIntermedia}
                ON {$tablaIntermedia}.{$fkRelacion} = {$tablaPrincipal}.id
            WHERE {$tablaIntermedia}.{$fkPrincipal} = '{$valorPrincipal}'
        ";

        return static::consultarSQL($query);
    }

    public static function startsWith(string $columna, string $valor, int $limite = 6) {
        if(!in_array($columna, static::$columnasDB, true)) return [];

        $valor = self::$db->escape_string($valor);
        $limite = filter_var($limite, FILTER_VALIDATE_INT);

        if($limite < 1) return [];

        $query = "
            SELECT * FROM " . static::$tabla . "
            WHERE $columna LIKE '{$valor}%'
            ORDER BY $columna ASC
            LIMIT $limite
        ";

        return static::consultarSQL($query);
    }
}