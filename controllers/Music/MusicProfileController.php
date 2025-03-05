<?php

namespace Controllers\Music;

use MVC\Router;
use Model\Terms;
use Model\Sellos;
use Model\Empresa;
use Model\Privacy;
use Model\Usuario;
use Model\NTMusica;
use Model\CTRMusical;
use Model\Comunicados;
use Model\CTRArtistico;
use Model\PerfilUsuario;
use Model\UsuarioSellos;

class MusicProfileController{
    public static function index(Router $router){
        isMusico();
        $alertas = Usuario::getAlertas();
        $usuario = Usuario::find($_SESSION['id']);

        $titulo = 'music_profile-title';        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;

            if($args['password'] === ''){
                $args['password'] = $usuario->password;
                $args['password2'] = $usuario->password;
            }

            $usuario->sincronizar($args);
            $usuario->nombre = sText($usuario->nombre);
            $usuario->apellido = sText($usuario->apellido);
            $alertas = $usuario->validarPassword();
            
            if(empty($alertas)){
                unset($usuario->password2);
                $usuario->hashPassword();
                $usuario->guardar();
                $alertas = Usuario::setAlerta('exito','profile_alert-profile-updated');          
            }            
        } 
        $alertas = Usuario::getAlertas();

        $router->render('music/profile/index',[
            'titulo' => $titulo,
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function delete(){
        isMusico();
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $usuario = Usuario::find($id);
        $ntmusica = NTMusica::where('id_usuario', $id);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id);
        $UsuarioSellos = UsuarioSellos::whereAll('id_usuario', $id);
        $sellos = Sellos::whereAll('id', $UsuarioSellos->id_sellos);
        if($perfilUsuario){
            $consulta='SELECT sellos.* FROM sellos
            INNER JOIN usuario_sellos ON sellos.id = usuario_sellos.id_sellos
            WHERE usuario_sellos.id_usuario = 26;';
            $consulta = Sellos::consultarSQL($consulta);
            if($consulta){
                foreach ($consulta as $sello) {
                    $sello->eliminar();
                }
            }
            $empresa = Empresa::find($perfilUsuario->id_empresa);
            $ctr_music = CTRMusical::where('id_empresa', $empresa->id);
            $ctr_artistico = CTRArtistico::where('id_empresa', $empresa->id);
            $terms = Terms::where('id_usuario', $usuario->id);
            $privacy = Privacy::where('id_usuario', $usuario->id);
            $comunicados = Comunicados::where('id_usuario', $usuario->id);
            if($ctr_music){
                $file = $ctr_music->nombre_doc;
                $file_route = '../public/contracts/'.$file;
                //delete the file
                unlink($file_route);
                $ctr_music->eliminar();
            }
            if($ctr_artistico){
                $file2 = $ctr_artistico->nombre_doc;
                $file_route2 = '../public/contracts/'.$file2;
                //delete the file
                unlink($file_route2);
                $ctr_artistico->eliminar();
            }
            $terms->eliminar();
            $privacy->eliminar();
            if($comunicados){
                $comunicados->eliminar();
            }
            $perfilUsuario->eliminar();
            $empresa->eliminar();
        }
        $ntmusica->eliminar();
        $resultado = $usuario->eliminar();

        if($resultado){
            $_SESSION = [];
            session_destroy();
            header('Location: /');
        } 
    }
}