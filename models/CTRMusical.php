<?php

namespace Model;

class CTRMusical extends ActiveRecord{
    protected static $tabla = 'ctr_musical';
    protected static $columnasDB = ['id', 'nombre_doc', 'fecha', 'id_usuario', 'id_empresa'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_doc = $args['nombre_doc'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y/m/d H:i:s');
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->id_empresa = $args['id_empresa'] ?? null;
    }
}