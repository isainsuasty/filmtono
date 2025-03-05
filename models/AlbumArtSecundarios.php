<?php

namespace Model;

class AlbumArtSecundarios extends ActiveRecord{
    protected static $tabla = 'album_artsecundarios';
    protected static $columnasDB = ['id', 'id_albums', 'artistas'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_albums = $args['id_albums'] ?? '';
        $this->artistas = $args['artistas'] ?? '';
    }
}