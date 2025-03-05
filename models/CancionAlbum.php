<?php

namespace Model;

class CancionAlbum extends ActiveRecord{
    protected static $tabla = 'canc_album';
    protected static $columnasDB = ['id', 'id_album', 'id_cancion'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_album = $args['id_album'] ?? '';
        $this->id_cancion = $args['id_cancion'] ?? '';
    }
}