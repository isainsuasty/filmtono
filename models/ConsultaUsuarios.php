<?php

namespace Model;

class ConsultaUsuarios extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'confirmado', 'perfil', 'nivel', 'tipo_es', 'tipo_en', 'empresa', 'pais', 'cargo', 'tel_contacto', 'pais_contacto', 'aprobado'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $confirmado;
    public $perfil;
    public $nivel;
    public $tipo_es;
    public $tipo_en;
    public $empresa;
    public $pais;
    public $cargo;
    public $tel_contacto;
    public $pais_contacto;
    public $aprobado;
   
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
        $this->perfil = $args['perfil'] ?? '';
        $this->nivel = $args['nivel'] ?? '';
        $this->tipo_es = $args['tipo_es'] ?? '';
        $this->tipo_en = $args['tipo_en'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->cargo = $args['cargo'] ?? '';
        $this->tel_contacto = $args['tel_contacto'] ?? '';
        $this->pais_contacto = $args['pais_contacto'] ?? '';
        $this->aprobado = $args['aprobado'] ?? '';
    }
}