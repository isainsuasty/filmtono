<?php

namespace Model;

class ContratosUsuario extends ActiveRecord{
    protected static $tabla = 'ctr_musical';
    protected static $columnasDB = ['id', 'fecha', 'nombre_doc', 'nombre', 'apellido', 'empresa', 'id_usuario', 'id_empresa'];

    public $id;
    public $fecha;
    public $nombre_doc;
    public $nombre;
    public $apellido;
    public $empresa;
    public $id_usuario;
    public $id_empresa;
   
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->nombre_doc = $args['nombre_doc'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->id_empresa = $args['id_empresa'] ?? '';
    }
}