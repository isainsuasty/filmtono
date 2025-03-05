<?php

namespace Model;

class Albums extends ActiveRecord{
    protected static $tabla = 'albums';
    protected static $columnasDB = ['id', 'titulo', 'portada', 'upc', 'fecha_rec', 'id_usuario', 'sello'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->portada = $args['portada'] ?? '';
        $this->upc = $args['upc'] ?? '';
        $this->fecha_rec = $args['fecha_rec'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->sello = $args['sello'] ?? '';
    }

    public function validarAlbum(){
        if(!$this->titulo) {
            self::$alertas['error'][] = 'music_albums_mandatory-title';
        }
        if(!$this->upc) {
            self::$alertas['error'][] = 'music_albums_mandatory-upc';
        }
        //check that the field UPC only contains letters and numbers, no symbols
        if(!preg_match('/^[a-zA-Z0-9]+$/', $this->upc)) {
            self::$alertas['error'][] = 'music_albums_symbols-upc';
        }
        if(strlen($this->upc) > 13 || strlen($this->upc) < 12) {
            self::$alertas['error'][] = 'music_albums_characters-upc';
        }
        if(!$this->fecha_rec) {
            self::$alertas['error'][] = 'music_albums_mandatory_record_date';
        }
        return self::$alertas;
    }
}