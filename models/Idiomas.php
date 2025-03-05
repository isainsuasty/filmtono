<?php

namespace Model;

class Idiomas extends ActiveRecord{
    protected static $tabla = 'idiomas';
    protected static $columnasDB = ['id', 'idioma_en', 'idioma_es'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idioma_en = $args['idioma_en'] ?? '';
        $this->idioma_es = $args['idioma_es'] ?? '';
    }

    // Validación para sellos al agregar un álbum
    public function validar() {
        if(!$this->idioma_en) {
            self::$alertas['error'][] = 'languages_mandatory-language-name-en';
        }
        if(!$this->idioma_es) {
            self::$alertas['error'][] = 'languages_mandatory-language-name-es';
        }
        return self::$alertas;
    }
}
