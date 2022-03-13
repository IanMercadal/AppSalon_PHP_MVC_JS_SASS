<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login');
    }

    public static function logout() {
        echo "Desde LogOut";
    }

    public static function olvide(Router $router) {
        $router->render('auth/olvide-password', [

        ]);
    }
    
    public static function recuperar() {
        echo "Desde Recuperar";
    }
    public static function crear(Router $router) {
        $usuario = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            debuguear($usuario);
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario
        ]);
    }
}
?>