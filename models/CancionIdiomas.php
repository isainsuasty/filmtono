<?php

namespace Model;

class CancionIdiomas extends ActiveRecord{
    protected static $tabla = 'canc_idiomas';
    protected static $columnasDB = ['id', 'id_cancion', 'id_idioma'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->id_idioma = $args['id_idioma'] ?? '';
    }
}
