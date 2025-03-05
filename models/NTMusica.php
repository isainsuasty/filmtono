<?php

namespace Model;

class NTMusica extends ActiveRecord{
    protected static $tabla = 'n_t_musica';
    protected static $columnasDB = ['id', 'id_usuario', 'id_nivel', 'id_musica'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->id_nivel = $args['id_nivel'] ?? '';
        $this->id_musica = $args['id_musica'] ?? '';
    }

    public function validar_tipo() {
        if(!$this->id_musica) {
            self::$alertas['error'][] = 'auth_alert_must_select_type_musician';
        }
        return self::$alertas;
    }
}
