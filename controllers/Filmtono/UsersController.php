<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Terms;
use Model\Albums;
use Model\Sellos;
use Classes\Email;
use Model\Empresa;
use Model\NTAdmin;
use Model\Privacy;
use Model\Usuario;
use Model\NTMusica;
use Model\Canciones;
use Model\CTRMusical;
use Model\TipoMusica;
use Model\Comunicados;
use Model\CancionAlbum;
use Model\CTRArtistico;
use Model\PerfilUsuario;
use Model\UsuarioSellos;

class UsersController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'users_main_title';
        $usuarios = Usuario::All();
        $router->render('/admin/users/index',[
            'titulo' => $titulo,
            'usuarios' => $usuarios
        ]);
    }

    public static function current(Router $router){
        isAdmin();
        $titulo = 'users_main_title';
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $empresa = null;
        $ntadmin = null;
        $ntmusica = null;
        $tipoMusica = null;
        $usuario = Usuario::find($id);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id);
        if($perfilUsuario !== null){
            $empresa = Empresa::find($perfilUsuario->id_empresa);
        }
        $ntadmin = NTAdmin::where('id_usuario', $id);
        $ntmusica = NTMusica::where('id_usuario', $id);
        if($ntmusica !== null){
            $tipoMusica = TipoMusica::find($ntmusica->id_musica);
        }

        $router->render('/admin/users/current',[
            'titulo' => $titulo,
            'usuario' => $usuario,
            'empresa' => $empresa,
            'ntadmin' => $ntadmin,
            'ntmusica' => $ntmusica,
            'tipoMusica' => $tipoMusica
        ]);
    }

    public static function new(Router $router){
        isAdmin();
        $lang = $_SESSION['lang'] ?? 'en';
        $alertas = [];
        $titulo = 'users_new_title';
        $usuario = new Usuario();
        $tipoAdmin = new NTAdmin();
        $musico = TipoMusica::allOrderBy('tipo_'.$lang);
        $tipoMusico = new NTMusica;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_tipo= $_POST['id_musica'];
            $usuario->sincronizar($_POST);
            $tipoMusico->sincronizar($_POST);
            $alertas = $usuario->validar_cuenta();
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario) {
                    Usuario::setAlerta('error', 'auth_alert_user-already-exist');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();
                    // Eliminar password2
                    unset($usuario->password2);
                    $resultado =  $usuario->guardar();
                    // Generar el Token
                    $usuario->crearToken();
                    if($id_tipo){
                        if($tipoMusico->id_musica === '1' || $tipoMusico->id_musica === '2'){
                            $tipoMusico->id_nivel = '2';
                        } elseif($tipoMusico->id_musica === '3'){
                            $tipoMusico->id_nivel = '3';
                        }
                        $tipoMusico->id_usuario = $resultado['id'];
                        $tipoMusico->guardar();
                    }else{
                        $tipoAdmin->id_usuario = $resultado['id'];
                        $tipoAdmin->id_nivel = 1;
                        $tipoAdmin->guardar();
                        $usuario->perfil = 1;
                    }

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    if($lang == 'en'){
                        $email->enviarConfirmacion();
                    } else{
                        $email->enviarConfirmacionEs();
                    }
                    
                    if($resultado) {
                        header('Location: /filmtono/users');
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('/admin/users/new',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'usuario' => $usuario,
            'musico' => $musico,
            'lang' => $lang
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $usuario = Usuario::find($id);
        $ntadmin = NTAdmin::where('id_usuario', $id);
        $ntmusica = NTMusica::where('id_usuario', $id);
        $album = Albums::where('id_usuario', $id);
        $songs = Canciones::whereAll('id_usuario', $id);
        if($album){
            $albumSongs = CancionAlbum::whereAll('id_album', $album->id);
        }
        if($ntadmin){
            $resultado = $ntadmin->eliminar();
            $resultado = $usuario->eliminar();
            if($resultado) {
                header('Location: /filmtono/users');
            }
        }elseif($ntmusica){
            $perfilUsuario = PerfilUsuario::where('id_usuario', $id);
            if($perfilUsuario){
                if($albumSongs){
                    foreach($albumSongs as $albumSong){
                        //search songs by each id
                        $song = Canciones::find($albumSong->id_cancion);
                        //delete the song
                        $song->eliminar();
                    }
                    //delete the album
                    $album->eliminar();
                }

                if($songs){
                    foreach($songs as $song){
                        $song->eliminar();
                    }
                }

                $usuarioSellos = UsuarioSellos::whereAll('id_usuario', $id);
                $consulta='SELECT sellos.* FROM sellos
                INNER JOIN usuario_sellos ON sellos.id = usuario_sellos.id_sellos
                WHERE usuario_sellos.id_usuario ='.$id.';';
                $consulta = Sellos::consultarSQL($consulta);
                if($consulta){
                    foreach($usuarioSellos as $usuarioSello){
                        $usuarioSello->eliminar();
                    }
                    
                    foreach ($consulta as $sello) {
                        $sello->eliminar();
                    }
                }
                $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
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
                if($terms){
                    $terms->eliminar();
                }
                if($privacy){
                    $privacy->eliminar();
                }
                if($comunicados){
                    $comunicados->eliminar();
                }
                $perfilUsuario->eliminar();
                $empresa->eliminar();
            }
            $ntmusica->eliminar();
            $usuario->eliminar();
            header('Location: /filmtono/users');

        }else{
            $usuario->eliminar();
            header('Location: /filmtono/users');
        }
    }
}