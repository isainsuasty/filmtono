<?php

namespace Model;

class CancionEscritores extends ActiveRecord{
    protected static $tabla = 'canc_escritores';
    protected static $columnasDB = ['id', 'id_cancion', 'escritores'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->escritores = $args['escritores'] ?? '';
    }

    public function validarCancionEscritores(){
        if (!$this->escritores) {
            self::$alertas['error'][] = "music_songs_form-writers_alert-required";
        }
        return self::$alertas;
    }
}
