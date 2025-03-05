<?php

namespace Model;

class ContactoCompra extends ActiveRecord{
    protected static $tabla = 'contacto_compra';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'pais', 'telefono', 'presupuesto', 'mensaje'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->presupuesto = $args['presupuesto'] ?? '';
        $this->mensaje = $args['mensaje'] ?? '';
    }

    public function validar()
    {
        if(!$this->nombre){
            self::$alertas['error'][] = "auth_alert_name-required";
        }

        if(!$this->apellido){
            self::$alertas['error'][] = "auth_alert_last_name-required";
        }

        if(!$this->email){
            self::$alertas['error'][] = "auth_alert_email-required";
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = "auth_alert_email-invalid";
        }

        if(!$this->pais){
            self::$alertas['error'][] = "auth_alert_country-required";
        }

        if(!$this->telefono){
            self::$alertas['error'][] = "auth_alert_phone-required";
        }

        if(!$this->mensaje){
            self::$alertas['error'][] = "auth_alert_message-required";
        }

        if(strlen($this->mensaje) > 200){
            self::$alertas['error'][] = "auth_alert_message-maxlength";
        }

        if(strlen($this->mensaje) < 10){
            self::$alertas['error'][] = "auth_alert_message-minlength";
        }

        return self::$alertas;
    }
}