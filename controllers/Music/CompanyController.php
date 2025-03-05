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


class CompanyController{
    public static function index(Router $router){
        isMusico();
        $titulo = 'company_title';
        $alertas = [];
        $perfilUsuario = PerfilUsuario::where('id_usuario', $_SESSION['id']);
        $empresa = Empresa::find($perfilUsuario->id_empresa);
        $tipoUsuario = NTMusica::where('id_usuario', $_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $empresa->sincronizar($_POST);
            $empresa->empresa = sText($empresa->empresa);
            $alertas = $empresa->validar();
            if(empty($alertas)){
                if($tipoUsuario->id_musica == '3'){
                    $UsuarioSello = UsuarioSellos::where('id_empresa', $empresa->id);
                    $sello = Sellos::find($UsuarioSello->id_sellos);
                    $sello->nombre = $empresa->empresa;
                    $sello->guardar();
                 }
                $empresa->guardar();
                Empresa::setAlerta('exito', 'auth_alert_success');
            }else{
                Empresa::setAlerta('error', 'auth_alert_error');
            }
        }
        $alertas = Empresa::getAlertas();
        $router->render('music/company/index',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'empresa' => $empresa
        ]);
    }

    public static function contracts(Router $router){
        isMusico();
        $titulo = 'contracts_main-title';
        $alertas = [];
        $contratoArtistico = CTRArtistico::where('id_usuario', $_SESSION['id']);
        $contratoMusical = CTRMusical::where('id_usuario', $_SESSION['id']);

        $router->render('music/company/contracts',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'contratoArtistico' => $contratoArtistico,
            'contratoMusical' => $contratoMusical
        ]);
    }

    public static function delete(Router $router){
        isMusico();
        $id = s($_GET['id']);
        $empresa = Empresa::find($id);
        $contratoMusical = CTRMusical::where('id_empresa', $id);
        $contratoArtistico = CTRArtistico::where('id_empresa', $id);
        $perfilUsuario = PerfilUsuario::where('id_empresa', $id);
        $usuario = Usuario::find($perfilUsuario->id_usuario);
        $usuario->perfil = '0';
        $_SESSION['perfil'] = $usuario->perfil;
        $privacy = Privacy::where('id_usuario', $usuario->id);
        $terms = Terms::where('id_usuario', $usuario->id);
        $comunicados = Comunicados::where('id_usuario', $usuario->id);
        if($_SESSION['nivel_musica'] == '3'){
            $sello = Sellos::where('nombre', $empresa->empresa);
            $usuarioSellos = UsuarioSellos::where('id_usuario', $usuario->id);
            $sello->eliminar();
            $usuarioSellos->eliminar();
        }

        if($contratoMusical){
            $file = $contratoMusical->nombre_doc;
            $file_route = '../public/contracts/'.$file;
            unlink($file_route);
        }
        if($contratoArtistico){
            $file2 = $contratoArtistico->nombre_doc;
            $file_route2 = '../public/contracts/'.$file2;
            unlink($file_route2);
        }

        $comunicados->eliminar();
        $privacy->eliminar();
        $terms->eliminar();
        $contratoArtistico->eliminar();
        $contratoMusical->eliminar();
        $perfilUsuario->eliminar();
        $empresa->eliminar();
        $usuario->guardar();
        header('Location: /music/dashboard');
    }
}