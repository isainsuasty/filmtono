<?php

namespace Model;

class AlbumIdiomas extends ActiveRecord{
    protected static $tabla = 'album_idiomas';
    protected static $columnasDB = ['id', 'id_album', 'id_idioma'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_album = $args['id_album'] ?? '';
        $this->id_idioma = $args['id_idioma'] ?? '';
    }
}