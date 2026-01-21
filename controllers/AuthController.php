<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class AuthController {


    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);

            $alertas = $user->validarLogin();

            if(empty($alertas)) {
                $user = User::where('email', $user->email);

                if(!$user || !$user->confirmed) {
                    User::setAlerta('error', 'El usuario no existe o no esta confirmado');
                } else {
                    if(password_verify($_POST['password'], $user->password)) {
                        session_start();

                        $_SESSION['id'] = $user->id;
                        $_SESSION['nombre'] = $user->nombre;
                        $_SESSION['apellido'] = $user->apellido;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin;

                        if($user->admin) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /');
                        }
                    } else {
                        User::setAlerta('error', 'La contraseña es Incorrecta');
                    }
                }
            }
        }

        $alertas = User::getAlertas();

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
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

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alertas = $user->validarEmail();
            
            if(empty($alertas)) {
                $user = User::where('email', $user->email);
                if($user && $user->confirmed) {
                    $user->crearToken();

                    unset($user->password2);

                    $user->guardar();

                    // Enviar el email
                    $email = new Email( $user->email, $user->name, $user->token );
                    $email->enviarInstrucciones();

                    User::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                } else {
                    User::setAlerta('error', 'El usuario no esta Registrado o no esta Confirmado');
                }
            }
        }

        $alertas = User::getAlertas();

        $router->render('auth/forget', [
            'titulo' => 'Olvide mi Contraseña',
            'alertas' => $alertas
        ]);
    }


    public static function confirm(Router $router) {
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlerta('error', 'Token no válido, la cuenta no se confirmó');
            $alertas = User::getAlertas();
        } else {
            $user->confirmed = 1;
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
        $token = $_GET['token'];


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