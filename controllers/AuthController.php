<?php

namespace Controllers;

use MVC\Router;

class AuthController {
    public static function login(Router $router) {


        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }

    public static function register(Router $router) {


        $router->render('auth/register', [
            'titulo' => 'Crear Cuenta'
        ]);
    }

    public static function forget(Router $router) {


        $router->render('auth/forget', [
            'titulo' => 'Olvide mi Contraseña'
        ]);
    }

    public static function confirm(Router $router) {


        $router->render('auth/confirm', [
            'titulo' => 'Confirmar Cuenta'
        ]);
    }

    public static function restore(Router $router) {


        $router->render('auth/restore', [
            'titulo' => 'Recuperar Cuenta'
        ]);
    }

    public static function message(Router $router) {


        $router->render('auth/message', [
            'titulo' => 'Cuenta Creada'
        ]);
    }
}