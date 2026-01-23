<?php

namespace Controllers;

use Classes\Paginacion;
use Model\User;
use Model\Users;
use MVC\Router;

class UsersController {


    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/users?page=1');
        }
        $registros_por_pagina = 9;
        $total = Users::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        $users = Users::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/users/index', [
            'titulo' => 'Usuarios Registrados',
            'users' => $users,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $user = User::find($id);

            if(!isset($user)) {
                header('Location: /admin/users');
            }

            $resultado  = $user->eliminar();

            if($resultado) {
                header('Location: /admin/users');
            }
        }
    }
}