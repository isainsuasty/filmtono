<?php

namespace Model;

class AlbumArtista extends ActiveRecord{
    protected static $tabla = 'album_artistas';
    protected static $columnasDB = ['id', 'id_albums', 'id_artistas'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_albums = $args['id_albums'] ?? '';
        $this->id_artistas = $args['id_artistas'] ?? '';
    }
}