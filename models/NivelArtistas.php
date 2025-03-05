<?php

namespace Model;

class NivelArtistas extends ActiveRecord{
    protected static $tabla = 'nivel_artistas';
    protected static $columnasDB = ['id', 'nombre', 'precio_show', 'nivel_en', 'nivel_es', 'id_usuario', 'empresa', 'instagram', 'facebook', 'twitter', 'youtube', 'spotify', 'tiktok', 'website', 'banner'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio_show = $args['precio_show'] ?? '';
        $this->nivel_en = $args['nivel_en'] ?? '';
        $this->nivel_es = $args['nivel_es'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->instagram = $args['instagram'] ?? '';
        $this->facebook = $args['facebook'] ?? '';
        $this->twitter = $args['twitter'] ?? '';
        $this->youtube = $args['youtube'] ?? '';
        $this->spotify = $args['spotify'] ?? '';
        $this->tiktok = $args['tiktok'] ?? '';
        $this->website = $args['website'] ?? '';
        $this->banner = $args['banner'] ?? '';
    }
}
