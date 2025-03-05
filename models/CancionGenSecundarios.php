<?php

namespace Model;

class CancionGenSecundarios extends ActiveRecord{
    protected static $tabla = 'canc_gensecundarios';
    protected static $columnasDB = ['id', 'id_cancion', 'id_genero'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->id_genero = $args['id_genero'] ?? '';
    }
}
