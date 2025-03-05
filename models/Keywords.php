<?php

namespace Model;

class Keywords extends ActiveRecord{
    protected static $tabla = 'keywords';
    protected static $columnasDB = ['id', 'keyword_en', 'keyword_es'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->keyword_en = $args['keyword_en'] ?? '';
        $this->keyword_es = $args['keyword_es'] ?? '';
    }

    public function validar() {
        if(!$this->keyword_en) {
            self::$alertas['error'][] = 'keywords_mandatory-keyword-name-en';
        }
        if(!$this->keyword_es) {
            self::$alertas['error'][] = 'keywords_mandatory-keyword-name-es';
        }
        return self::$alertas;
    }
}
