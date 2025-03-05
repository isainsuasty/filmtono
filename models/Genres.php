<?php

namespace Model;

class Genres extends ActiveRecord{
    protected static $tabla = 'generos';
    protected static $columnasDB = ['id', 'genero_en', 'genero_es'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->genero_en = $args['genero_en'] ?? '';
        $this->genero_es = $args['genero_es'] ?? '';
    }

    public function validar() {
        if(!$this->genero_en) {
            self::$alertas['error'][] = 'admin_genres_form-name_spanish_mandatory';
        }
        if(!$this->genero_es) {
            self::$alertas['error'][] = 'admin_genres_form-name_english_mandatory';
        }
        return self::$alertas;
    }
}
