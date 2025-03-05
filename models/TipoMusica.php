<?php

namespace Model;

class TipoMusica extends ActiveRecord{
    protected static $tabla = 'tipo_musica';
    protected static $columnasDB = ['id', 'tipo_es', 'tipo_en'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->tipo_es = $args['tipo_es'] ?? '';
        $this->tipo_en = $args['tipo_en'] ?? '';
    }
}
