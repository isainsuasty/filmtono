<?php

namespace Model;

class Privacy extends ActiveRecord{
    protected static $tabla = 'privacy';
    protected static $columnasDB = ['id', 'privacy', 'version', 'id_usuario'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->privacy = $args['privacy'] ?? '';
        $this->version = $args['version'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
    }
}