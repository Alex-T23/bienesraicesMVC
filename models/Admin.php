<?php

namespace Model;

class Admin extends ActiveRecord {
    //BD
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if(!$this->email){
            self::$errores[] = "El email es obligatorio o no es válido";
        }
        if(!$this->password){
            self::$errores[] = "La contraseña es obligatoria";
        }

        return self::$errores;
    }

    public function existeUsuario(){
        //revisar si existe el usuario
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if(!$resultado->num_rows) {
            self::$errores[] = "El usuario no existe";
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password);

        if(!$autenticado){
            self::$errores[] = "Contraseña incorrecta";
        }

        return $autenticado;
    }

    public function autenticar(){
        session_start();

        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}