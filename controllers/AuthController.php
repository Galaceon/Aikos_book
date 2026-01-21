<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController {


    public static function login(Router $router) {


        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }


    public static function register(Router $router) {
        $user = new User;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);


            $alertas = $user->validar_cuenta();

            if(empty($alertas)) {
                $existeUsuario = User::where('email', $user->email);
                
                if($existeUsuario) {
                    User::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = User::getAlertas();
                } else {
                    $user->hashPassword();

                    unset($user->password2);

                    $user->crearToken();

                    $user->created_at = date('Y-m-d H:i:s');

                    $user->image = 'default_user_img';

                    $resultado = $user->guardar();

                    $email = new Email($user->email, $user->name, $user->token);
                    $email->enviarConfirmacion();
                    

                    if($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/register', [
            'titulo' => 'Crear Cuenta',
            'alertas' => $alertas,
            'user' => $user
        ]);
    }


    public static function forget(Router $router) {


        $router->render('auth/forget', [
            'titulo' => 'Olvide mi Contraseña'
        ]);
    }


    public static function confirm(Router $router) {
        $token = s($_GET['token']);

        if(!$token) header('Location: /login');

        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlerta('error', 'Token no válido, la cuenta no se confirmó');
            $alertas = User::getAlertas();
        } else {
            $user->confirmado = 1;
            $user->token = '';
            unset($user->password2);
            
            // Guardar en la BD
            $user->guardar();

            User::setAlerta('exito', 'Cuenta Comprobada éxitosamente');
        }

        $alertas = User::getAlertas();

        $router->render('auth/confirm', [
            'titulo' => 'Confirmar Cuenta',
            'alertas' => $alertas
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