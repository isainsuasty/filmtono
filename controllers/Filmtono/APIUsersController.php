<?php

namespace Controllers\Filmtono;

use Model\Usuario;
use Model\NTMusica;
use Model\UsuarioTipo;
use Model\ConsultaUsuarios;

class APIUsersController{
    public static function usuarios(){
        isAdmin();
        $consulta = "SELECT u.id, 
        u.nombre, 
        u.apellido, 
        u.email,
        u.confirmado,
        u.perfil,
        u.aprobado,        
        nu.nivel,
        tm.tipo_es,
        tm.tipo_en,
        e.empresa,
        e.cargo
     
        FROM 
        usuarios u
        LEFT JOIN n_t_admin a ON u.id = a.id_usuario
        LEFT JOIN n_t_musica m ON u.id = m.id_usuario
        LEFT JOIN nivel_usuario nu ON m.id_nivel = nu.id
        LEFT JOIN tipo_musica tm ON m.id_musica = tm.id
        LEFT JOIN perfil_usuario pu ON u.id = pu.id_usuario
        LEFT JOIN empresa e ON pu.id_empresa = e.id
        ORDER BY u.nombre;";

        //$usuarios = Usuario::All();

        $usuarios = ConsultaUsuarios::consultarSQL($consulta);
        
        echo json_encode($usuarios);
    }

    public static function aprobarUsuario(){
        isAdmin();
        $respuesta = $_POST['id'];
        //debugging($_POST);
        $usuario = Usuario::find($respuesta);
        $usuario->aprobado = 1;
        $resultado = $usuario->guardar();

        echo json_encode(['resultado' => $resultado]);
    }
}