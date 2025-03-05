<?php

namespace Model;

class Promos extends ActiveRecord{
    protected static $tabla = 'promos';
    protected static $columnasDB = ['id', 'promos'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->promos = $args['promos'] ?? '';
    }

    public function validarPromos(){
        if(!$this->promos) {
            self::$alertas['error'][] = 'admin_alert_mandatory-file';
        }
        return self::$alertas;
    }
}