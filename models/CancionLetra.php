<?php

namespace Model;

class CancionLetra extends ActiveRecord{
    protected static $tabla = 'canc_letra';
    protected static $columnasDB = ['id', 'id_cancion', 'letra'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->letra = $args['letra'] ?? '';
    }
}
