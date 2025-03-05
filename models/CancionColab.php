<?php

namespace Model;

class CancionColab extends ActiveRecord{
    protected static $tabla = 'canc_colaboradores';
    protected static $columnasDB = ['id', 'id_cancion', 'colaboradores'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->colaboradores = $args['colaboradores'] ?? '';
    }
}
