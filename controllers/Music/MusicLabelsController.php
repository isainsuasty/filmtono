<?php

namespace Controllers\Music;

use MVC\Router;
use Model\Sellos;
use Model\Usuario;
use Model\PerfilUsuario;
use Model\UsuarioSellos;

class MusicLabelsController{
    public static function index(Router $router){
        isMusico();
        $usuario = Usuario::find($_SESSION['id']);
        $usuarioId = $usuario->id;
        $consulta = 'SELECT sellos.id, sellos.nombre, sellos.creado FROM sellos INNER JOIN usuario_sellos ON sellos.id = usuario_sellos.id_sellos INNER JOIN usuarios ON usuario_sellos.id_usuario = usuarios.id WHERE usuarios.id =' . $usuarioId .' ORDER BY sellos.nombre ASC';

        $sellos = Sellos::consultarSQL($consulta);
        //debugging($consulta);

        $titulo = 'music_labels-title';
        $router->render('music/labels/index',[
            'titulo' => $titulo,
            'sellos' => $sellos
        ]);
    }

    public static function consultarSellos(){
        isMusico();
        $usuario = Usuario::find($_SESSION['id']);
        $usuarioId = $usuario->id;
        $consulta = 'SELECT sellos.id, sellos.nombre, sellos.creado FROM sellos INNER JOIN usuario_sellos ON sellos.id = usuario_sellos.id_sellos INNER JOIN usuarios ON usuario_sellos.id_usuario = usuarios.id WHERE usuarios.id =' . $usuarioId .' ORDER BY sellos.nombre ASC';

        $sellos = Sellos::consultarSQL($consulta);
        echo json_encode($sellos);
    }

    public static function new(Router $router){
        isMusico();
        $sellos = new Sellos();
        $usuario = Usuario::find($_SESSION['id']);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $usuario->id);
        $titulo = 'music_labels_new-title';
        $alertas = Sellos::getAlertas();
        $usuarioSellos = new UsuarioSellos();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $sellos = new Sellos($_POST);
            $alertas = $sellos->validarSello();
            if(empty($alertas)){
                $sellos->guardar();
                $sellos = Sellos::where('nombre', $sellos->nombre);
                $usuarioSellos->id_usuario = $usuario->id;
                $usuarioSellos->id_sellos = $sellos->id;
                $usuarioSellos->id_empresa = $perfilUsuario->id_empresa;
                $usuarioSellos->guardar();
                header('Location: /music/labels');
            }
        }        

        $router->render('music/labels/new',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'sellos' => $sellos
        ]);
    }

    public static function edit(Router $router){
        isMusico();
        $id = redireccionar('/music/labels');
        $sellos = Sellos::find($id);
        $titulo = 'music_labels_edit-title';
        $alertas = Sellos::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $sellos->sincronizar($args);
            $alertas = $sellos->validarSello();

            if(empty($alertas)){
                $sellos->guardar();
            }
            header('Location: /music/labels');
        }

        $router->render('music/labels/edit',[
            'titulo' => $titulo,
            'sellos' => $sellos,
            'alertas' => $alertas
        ]);
    }

    public static function delete(){
        isMusico();
        $sellos = redireccionar('/music/labels');
        $sellos = Sellos::find($id);
        $resultado = $sellos->eliminar();
        if($resultado){
            header('Location: /music/labels');
        }
    }
}