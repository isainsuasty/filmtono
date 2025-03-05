<?php

namespace Model;

class CancionNivel extends ActiveRecord{
    protected static $tabla = 'canc_nivel';
    protected static $columnasDB = ['id', 'id_nivel', 'id_cancion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_nivel = $args['id_nivel'] ?? '';
        $this->id_cancion = $args['id_cancion'] ?? '';
    }

    public function validarCancionNivel() {
        if(!$this->id_nivel) {
            self::$alertas['error'][] = 'music_songs_form-song-level_alert-required';
        }
        return self::$alertas;
    }
}