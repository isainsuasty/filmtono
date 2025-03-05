<?php

namespace Model;

class CancionSelloPropiedad extends ActiveRecord{
    protected static $tabla = 'canc_sello_propiedad';
    protected static $columnasDB = ['id', 'sello_propiedad', 'id_cancion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->sello_propiedad = $args['sello_propiedad'] ?? '';
        $this->id_cancion = $args['id_cancion'] ?? '';
    }

    public function validarCancionSelloPropiedad(){
        if (!$this->sello_propiedad) {
            self::$alertas['error'][] = "music_songs-form-phonogram_alert-required";
        }
        return self::$alertas;
    }
}