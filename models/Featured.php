<?php

namespace Model;

class Featured extends ActiveRecord{
    protected static $tabla = 'featured';
    protected static $columnasDB = ['id', 'videoId', 'title'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->videoId = $args['videoId'] ?? '';
        $this->title = $args['title'] ?? '';
    }
}