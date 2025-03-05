<?php

namespace Model;

class CancionData extends ActiveRecord{
    protected static $tabla = 'canciones';
    protected static $columnasDB = ['id', 'titulo', 'version', 'isrc', 'url', 'sello', 'id_usuario', 'publisher', 'id_album', 'album', 'album_upc', 'album_publisher', 'album_fecha_record', 'artista_id', 'artista_name', 'nivel_cancion_en', 'nivel_cancion_es', 'genero_es', 'genero_en', 'categorias_en', 'categorias_es', 'colaboradores', 'gensec_en', 'gensec_es', 'idioma_en', 'idioma_es', 'instrumentos_en', 'instrumentos_es', 'keywords_en', 'keywords_es', 'letra', 'escritores', 'escritor_propiedad', 'publisher_propiedad', 'sello_propiedad'];

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
        $this->id_album = $args['id_album'] ?? '';
        $this->album = $args['album'] ?? '';
        $this->album_upc = $args['album_upc'] ?? '';
        $this->album_publisher = $args['album_publisher'] ?? '';
        $this->album_fecha_record = $args['album_fecha_record'] ?? '';
        $this->artista_id = $args['artista_id'] ?? '';
        $this->artista_name = $args['artista_name'] ?? '';
        $this->nivel_cancion_en = $args['nivel_cancion_en'] ?? '';
        $this->nivel_cancion_es = $args['nivel_cancion_es'] ?? '';
        $this->genero_es = $args['genero_es'] ?? '';
        $this->genero_en = $args['genero_en'] ?? '';
        $this->categorias_en = $args['categorias_en'] ?? '';
        $this->categorias_es = $args['categorias_es'] ?? '';
        $this->colaboradores = $args['colaboradores'] ?? '';
        $this->gensec_en = $args['gensec_en'] ?? '';
        $this->gensec_es = $args['gensec_es'] ?? '';
        $this->idioma_en = $args['idioma_en'] ?? '';
        $this->idioma_es = $args['idioma_es'] ?? '';
        $this->instrumentos_en = $args['instrumentos_en'] ?? '';
        $this->instrumentos_es = $args['instrumentos_es'] ?? '';
        $this->keywords_en = $args['keywords_en'] ?? '';
        $this->keywords_es = $args['keywords_es'] ?? '';
        $this->letra = $args['letra'] ?? '';
        $this->escritores = $args['escritores'] ?? '';
        $this->escritor_propiedad = $args['escritor_propiedad'] ?? '';
        $this->publisher_propiedad = $args['publisher_propiedad'] ?? '';
        $this->sello_propiedad = $args['sello_propiedad'] ?? '';
    }
}
