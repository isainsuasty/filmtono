<?php

namespace Model;

class Canciones extends ActiveRecord{
    protected static $tabla = 'canciones';
    protected static $columnasDB = ['id', 'titulo', 'version', 'isrc', 'url', 'sello', 'id_usuario', 'publisher'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->version = $args['version'] ?? '';
        $this->isrc = $args['isrc'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->sello = $args['sello'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->publisher = $args['publisher'] ?? '';
    }

    public function validarCancion() {
        if(!$this->titulo) {
            self::$alertas['error'][] = 'music_songs_form-title_alert-required';
        }
        if(!$this->version) {
            self::$alertas['error'][] = 'music_songs_form-version_alert-required';
        }
        if(strlen($this->version) > 50) {
            self::$alertas['error'][] = 'music_songs_form-version_alert-max';
        }
        if(!$this->isrc) {
            self::$alertas['error'][] = 'music_songs_form-isrc_alert-required';
        }
        //check that the field ISRC only contains letters and numbers, no symbols
        if(!preg_match('/^[a-zA-Z0-9]+$/', $this->isrc)) {
            self::$alertas['error'][] = 'music_songs_form-isrc_alert-symbols';
        }
        if(strlen($this->isrc) > 16 || strlen($this->isrc) < 12) {
            self::$alertas['error'][] = 'music_songs_form-isrc_alert-max';
        }
        if(!$this->url) {
            self::$alertas['error'][] = 'music_songs_form-youtube_alert-required';
        }
        if(!$this->publisher) {
            self::$alertas['error'][] = 'music_albums_mandatory_publisher';
        }
        return self::$alertas;
    }
}
