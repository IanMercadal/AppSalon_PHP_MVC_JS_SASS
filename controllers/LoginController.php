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
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header('Location:/mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        // Obtener alertas
        $alertas = Usuario::getAlertas();

        // renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
?>