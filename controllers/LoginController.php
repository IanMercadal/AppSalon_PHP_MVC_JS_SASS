<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\email;

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

        // Alertas vacías
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alerta este vacío
            if(empty($alertas)) {
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el Password
                    $usuario->hashPassword($resultado);

                    // Generar un Token único
                    $usuario->crearToken();

                    // Enviar el email
                    $email = new Email($usuario->nombre,$usuario->email,
                    $usuario->token);

                    debuguear($email);
                    debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}
?>