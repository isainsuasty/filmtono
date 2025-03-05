<?php

namespace Model;

class Artistas extends ActiveRecord{
    protected static $tabla = 'artistas';
    protected static $columnasDB = ['id', 'nombre', 'precio_show', 'id_nivel', 'id_usuario', 'instagram', 'facebook', 'twitter', 'youtube', 'spotify', 'tiktok', 'website', 'banner'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio_show = $args['precio_show'] ?? '';
        $this->id_nivel = $args['id_nivel'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->instagram = $args['instagram'] ?? '';
        $this->facebook = $args['facebook'] ?? '';
        $this->twitter = $args['twitter'] ?? '';
        $this->youtube = $args['youtube'] ?? '';
        $this->spotify = $args['spotify'] ?? '';
        $this->tiktok = $args['tiktok'] ?? '';
        $this->website = $args['website'] ?? '';
        $this->banner = $args['banner'] ?? '';
    }

    public function validarArtista(){
        if(!$this->nombre) {
            self::$alertas['error'][] = 'artists_mandatory_artist-name';
        }
        if(!$this->precio_show) {
            self::$alertas['error'][] = 'artists_mandatory_show-price';
        }
        if(!$this->id_nivel) {
            self::$alertas['error'][] = 'artists_mandatory_artist-level';
        }
        //validate url format for each social media
        if($this->instagram && !filter_var($this->instagram, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->facebook && !filter_var($this->facebook, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->twitter && !filter_var($this->twitter, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->youtube && !filter_var($this->youtube, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->spotify && !filter_var($this->spotify, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->tiktok && !filter_var($this->tiktok, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->website && !filter_var($this->website, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        if($this->banner && !filter_var($this->banner, FILTER_VALIDATE_URL)){
            self::$alertas['error'][] = 'invalid_url';
        }
        return self::$alertas;
    }
}