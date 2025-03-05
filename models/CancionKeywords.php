<?php

namespace Model;

class CancionKeywords extends ActiveRecord{
    protected static $tabla = 'canc_keywords';
    protected static $columnasDB = ['id', 'id_cancion', 'id_keywords'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->id_keywords = $args['id_keywords'] ?? '';
    }
}
