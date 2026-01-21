<?php

// Muestra información estructurada de una variable
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa el HTML especial para evitar ataques XSS
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Comprueba que la página actual(url) sea igual a la pasada como parámetro en $path
function pagina_actual(string $path): bool {
    return str_contains($_SERVER['REQUEST_URI'], $path);
}


// Verifica si el usuario está autenticado
function is_auth() : bool {
    return isset($_SESSION['name']) && !empty($_SESSION);
}

// Verifica si el usuario es administrador
function is_admin() : bool {
    return isset($_SESSION['admin']) && (int) $_SESSION['admin'] === 1;
}

function aos_animation() : void {
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right'];
    $efecto = array_rand($efectos, 1);

    echo $efectos[$efecto];
}