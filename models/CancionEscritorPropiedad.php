<?php

namespace Model;

class CancionEscritorPropiedad extends ActiveRecord{
    protected static $tabla = 'canc_escritor_propiedad';
    protected static $columnasDB = ['id', 'id_cancion', 'escritor_propiedad', 'publisher_propiedad'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_cancion = $args['id_cancion'] ?? '';
        $this->escritor_propiedad = $args['escritor_propiedad'] ?? '';
        $this->publisher_propiedad = $args['publisher_propiedad'] ?? '';
    }

    public function validarCancionEscritorPropiedad(){
        if (!$this->escritor_propiedad) {
            self::$alertas['error'][] = "music_songs_form-writers-percent_alert-required";
        }
        if (!$this->publisher_propiedad) {
            self::$alertas['error'][] = "music_songs_form-publisher-percent_alert-required";
        }
        return self::$alertas;
    }
}
