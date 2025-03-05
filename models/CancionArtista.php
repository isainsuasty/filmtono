<?php

namespace Model;

class CancionArtista extends ActiveRecord{
    protected static $tabla = 'canc_artista';
    protected static $columnasDB = ['id', 'id_artista', 'id_cancion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_artista = $args['id_artista'] ?? '';
        $this->id_cancion = $args['id_cancion'] ?? '';
    }

    public function validarCancionArtista() {
        if(!$this->id_artista) {
            self::$alertas['error'][] = 'music_songs_form-artist_alert-required';
        }
        return self::$alertas;
    }
}