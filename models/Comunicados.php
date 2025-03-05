<?php

namespace Model;

class Comunicados extends ActiveRecord{
    protected static $tabla = 'comunicados';
    protected static $columnasDB = ['id', 'comunicados', 'id_usuario'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->comunicados = $args['comunicados'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
    }
}