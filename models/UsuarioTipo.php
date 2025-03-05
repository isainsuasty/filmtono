<?php

namespace Model;

class UsuarioTipo extends ActiveRecord{
    protected static $tabla = 'usuario_tipo';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'confirmado', 'nivel_admin', 'nivel_musica', 'empresa'];
   
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $confirmado;
    public $nivel_admin;
    public $nivel_musica;
    public $empresa;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
        $this->nivel_admin = $args['nivel_admin'] ?? '';
        $this->nivel_musica = $args['nivel_musica'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
    }
}