<?php

namespace Model;

class NTAdmin extends ActiveRecord{
    protected static $tabla = 'n_t_admin';
    protected static $columnasDB = ['id', 'id_usuario', 'id_nivel'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->id_nivel = $args['id_nivel'] ?? '';
    }
}
