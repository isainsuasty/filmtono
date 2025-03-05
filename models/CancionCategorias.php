<?php

namespace Model;

class CancionCategorias extends ActiveRecord{
    protected static $tabla = 'canc_categorias';
    protected static $columnasDB = ['id', 'id_categoria', 'id_cancion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_categoria = $args['id_categoria'] ?? '';
        $this->id_cancion = $args['id_cancion'] ?? '';
    }
}