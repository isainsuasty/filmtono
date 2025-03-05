<?php

namespace Model;

class NivelCancion extends ActiveRecord{
    protected static $tabla = 'nivel_canc';
    protected static $columnasDB = ['id', 'nivel_en', 'nivel_es'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nivel_en = $args['nivel_en'] ?? '';
        $this->nivel_es = $args['nivel_es'] ?? '';
    }

    // Validación para sellos al agregar un álbum
    public function validar() {
        if(!$this->nivel_en) {
            self::$alertas['error'][] = 'categories_mandatory-category-name-en';
        }
        if(!$this->nivel_es) {
            self::$alertas['error'][] = 'categories_mandatory-category-name-es';
        }
        return self::$alertas;
    }
}
