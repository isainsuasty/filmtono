<?php

namespace Model;

class ArtistSongsPlayer extends ActiveRecord{
    protected static $tabla = 'canciones';
    protected static $columnasDB = ['videoId', 'title'];

    public function __construct($args = [])
    {
        $this->videoId = $args['videoId'] ?? '';
        $this->title = $args['title'] ?? '';
    }
}