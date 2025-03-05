<?php
namespace Controllers\Music;

use MVC\Router;
use Model\Albums;
use Model\Genres;
use Model\Artistas;
use Model\AlbumArtista;
use Model\NivelArtistas;

class MusicArtistsController{
    public static function index(Router $router){
        isMusico();
        $titulo = 'artists_main-title';
        $id = $_SESSION['id'];
        $consultaArtistas = 'SELECT 
            a.id, 
            a.nombre, 
            a.precio_show, 
            a.id_usuario,
            n.nivel_en, 
            n.nivel_es
        FROM 
            artistas a
        INNER JOIN 
            nivel_artistas n ON a.id_nivel = n.id
        WHERE 
            a.id_usuario = '.$id.'
        ORDER BY 
            a.nombre ASC;
        ';
        $artistas = NivelArtistas::consultarSQL($consultaArtistas);
        $router->render('music/artists/index',[
            'titulo' => $titulo,
            'artistas' => $artistas
        ]);
    }

    public static function consultaArtistas(){
        isMusico();
        $id = $_SESSION['id'];
        //debbuging($id);
        $consultaArtistas = 'SELECT 
            a.*, 
            a.id_usuario,
            n.nivel_en, 
            n.nivel_es
        FROM 
            artistas a
        INNER JOIN 
            nivel_artistas n ON a.id_nivel = n.id
        WHERE 
            a.id_usuario = '.$id.'
        ORDER BY 
            a.nombre ASC;
        ';
        $artistas = NivelArtistas::consultarSQL($consultaArtistas);
        echo json_encode($artistas);
    }

    public static function new(Router $router){
        isMusico();
        $titulo = 'artists_new-title';
        $alertas = [];
        $artista = new Artistas();
        $niveles = NivelArtistas::all();
        $lang = $_SESSION['lang'];
        $id = $_SESSION['id'];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $artista->sincronizar($_POST);
            $artista->nombre = sText($artista->nombre);
            $artista->precio_show = filter_var($artista->precio_show, FILTER_SANITIZE_NUMBER_INT);

            $alertas = $artista->validarArtista();
            if(empty($alertas)){
                $existeArtista = Artistas::where('nombre', $artista->nombre);
                if($existeArtista){
                    Artistas::setAlerta('error', 'artists_alert_already-exist');
                    $alertas = Artistas::getAlertas();
                }else{
                    $artista->id_usuario = $id;
                    $artista->banner = getYTVideoId($artista->banner);
                    $resultado = $artista->guardar();
                    if($resultado){
                        header('Location: /music/artists');
                    }
                }
            }
        }
        $router->render('music/artists/new',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'artista' => $artista,
            'niveles' => $niveles,
            'lang' => $lang
        ]);
    }

    public static function edit(Router $router){
        isMusico();
        $titulo = 'artists_edit-title';
        $id = redireccionar('/music/artists');
        $artista = Artistas::find($id);
        $alertas = Artistas::getAlertas();
        $niveles = NivelArtistas::all();
        $lang = $_SESSION['lang'];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $artista->sincronizar($_POST);
            $artista->nombre = sText($artista->nombre);
            $artista->precio_show = filter_var($artista->precio_show, FILTER_SANITIZE_NUMBER_INT);
            $alertas = $artista->validarArtista();

            if(empty($alertas)){
                if($artista->banner == ''){
                    $existeBanner = Artistas::where('id', $artista->id);
                    $artista->banner = $existeBanner->banner;
                }else{
                    $artista->banner = getYTVideoId($artista->banner);
                }
                $resultado = $artista->guardar();
                if($resultado){
                    header('Location: /music/artists');
                }
            }
        }
        $router->render('music/artists/edit',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'artista' => $artista,
            'niveles' => $niveles,
            'lang' => $lang
        ]);
    }

    public static function delete(){
        isMusico();
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $artista = Artistas::find($id);
        $resultado = $artista->eliminar();
        if($resultado){
            header('Location: /music/artists');
        }
    }
}