<?php

namespace Model;

class Terms extends ActiveRecord{
    protected static $tabla = 'terms';
    protected static $columnasDB = ['id', 'terms', 'version', 'id_usuario'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->terms = $args['terms'] ?? '';
        $this->version = $args['version'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
    }
}