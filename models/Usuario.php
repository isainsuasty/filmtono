<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'confirmado', 'token', 'perfil', 'aprobado'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->perfil = $args['perfil'] ?? 0;
        $this->aprobado = $args['aprobado'] ?? 0;
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'auth_alert_email-required';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'auth_alert_email-invalid';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'auth_alert_password-required';
        }
        return self::$alertas;

    }

    // Validación para cuentas nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'auth_alert_name-required';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'auth_alert_last_name-required';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'auth_alert_email-required';
        }
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'auth_alert_email-required';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'auth_alert_email-invalid';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'auth_alert_password-required';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'auth_alert_password-minlength';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'auth_alert_password-different';
        }
        //comprobar que el password tenga al menos una mayúscula y un número
        $uppercase = preg_match('@[A-Z]@', $this->password);
        $lowercase = preg_match('@[a-z]@', $this->password);
        $number    = preg_match('@[0-9]@', $this->password);
        
        if(!$uppercase || !$lowercase || !$number) {
            self::$alertas['error'][] = 'auth_alert_password-weak';
        }

        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'auth_alert_password_old-required';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'auth_alert_password_confirmation-required';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'auth_alert_password-minlength';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}