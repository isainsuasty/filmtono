<?php

namespace Model;

class CategKeyword extends ActiveRecord{
    protected static $tabla = 'categ_keyword';
    protected static $columnasDB = ['id', 'id_categoria', 'id_keyword'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_categoria = $args['id_categoria'] ?? '';
        $this->id_keyword = $args['id_keyword'] ?? '';
    }
}
