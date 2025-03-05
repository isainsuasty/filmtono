<?php

namespace Model;

class UsuarioAlbumArtista extends ActiveRecord{
    protected static $tabla = 'album_artistas';
    protected static $columnasDB = ['id', 'titulo', 'portada', 'upc', 'publisher', 'fecha_rec', 'id_usuario', 'sello', 'artista_id', 'artista_name'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->portada = $args['portada'] ?? '';
        $this->upc = $args['upc'] ?? '';
        $this->publisher = $args['publisher'] ?? '';
        $this->fecha_rec = $args['fecha_rec'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->sello = $args['sello'] ?? '';
        $this->artista_id = $args['artista_id'] ?? '';
        $this->artista_name = $args['artista_name'] ?? '';
    }
}