<?php

namespace Model;

class Categorias extends ActiveRecord{
    protected static $tabla = 'categorias';
    protected static $columnasDB = ['id', 'categoria_en', 'categoria_es', 'activo'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->categoria_en = $args['categoria_en'] ?? '';
        $this->categoria_es = $args['categoria_es'] ?? '';
        $this->activo = $args['activo'] ?? 1;
    }

    // Validación para sellos al agregar un álbum
    public function validar() {
        if(!$this->categoria_en) {
            self::$alertas['error'][] = 'categories_mandatory-category-name-en';
        }
        if(!$this->categoria_es) {
            self::$alertas['error'][] = 'categories_mandatory-category-name-es';
        }
        return self::$alertas;
    }
}
