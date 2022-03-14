<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido','email','password','telefono',
    'admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id= $args['id'] ?? null;
        $this->nombre= $args['nombre'] ?? null;
        $this->apellido= $args['apellido'] ?? null;
        $this->email= $args['email'] ?? null;
        $this->password= $args['password'] ?? null;
        $this->telefono= $args['telefono'] ?? null;
        $this->admin= $args['admin'] ?? null;
        $this->confirmado= $args['confirmado'] ?? null;
        $this->token= $args['token'] ?? null;
    }

    // Mensajes de validación para la creación de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Cliente es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido del Cliente es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Cliente es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password del Cliente es Obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6
            caracteres';
        }

        return self::$alertas;
    }

    // revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya está registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }
}

?>