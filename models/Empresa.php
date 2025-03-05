<?php

namespace Model;

class Empresa extends ActiveRecord{
    protected static $tabla = 'empresa';
    protected static $columnasDB = ['id', 'empresa', 'id_fiscal', 'direccion', 'pais', 'cargo', 'tel_contacto', 'pais_contacto', 'nombre_compras', 'apellido_compras', 'email_compras', 'tel_compras'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->empresa = $args['empresa'] ?? '';
        $this->id_fiscal = $args['id_fiscal'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->cargo = $args['cargo'] ?? '';
        $this->tel_contacto = $args['tel_contacto'] ?? '';
        $this->pais_contacto = $args['pais_contacto'] ?? '';
        $this->nombre_compras = $args['nombre_compras'] ?? '';
        $this->apellido_compras = $args['apellido_compras'] ?? '';
        $this->email_compras = $args['email_compras'] ?? '';
        $this->tel_compras = $args['tel_compras'] ?? '';
    }

    public function validar(){
        if(!$this->empresa){
            self::$alertas['error'][] = 'auth_alert_company-required';
        }
        if(!$this->id_fiscal){
            self::$alertas['error'][] = 'auth_alert_id-fiscal-required';
        }
        if(!$this->direccion){
            self::$alertas['error'][] = 'auth_alert_address-required';
        }
        if(!$this->pais){
            self::$alertas['error'][] = 'auth_alert_country-required';
        }
        if(!$this->cargo){
            self::$alertas['error'][] = 'auth_alert_company-position-required';
        }
        if(!$this->tel_contacto){
            self::$alertas['error'][] = 'auth_alert_phone-required';
        }
        if(!$this->pais_contacto){
            self::$alertas['error'][] = 'auth_alert_your-country-required';
        }
        return self::$alertas;
    }
}