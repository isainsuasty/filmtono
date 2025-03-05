<?php

namespace Model;

class CancionGenero extends ActiveRecord{
    protected static $tabla = 'canc_genero';
    protected static $columnasDB = ['id', 'id_cancion', 'id_genero'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->id_genero = $args['id_genero'] ?? '';
    }

    public function validarCancionGenero(){
        if (!$this->id_genero) {
            self::$alertas['error'][] = "music_songs_form-genre_alert-required";
        }
        return self::$alertas;
    }
}
