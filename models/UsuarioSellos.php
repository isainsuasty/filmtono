<?php

namespace Model;

class UsuarioSellos extends ActiveRecord{
    protected static $tabla = 'usuario_sellos';
    protected static $columnasDB = ['id', 'id_usuario', 'id_sellos', 'id_empresa'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->id_sellos = $args['id_sellos'] ?? '';
        $this->id_empresa = $args['id_empresa'] ?? '';
    }
}