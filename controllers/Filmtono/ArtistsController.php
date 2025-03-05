<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Artistas;
use Model\NivelArtistas;

class ArtistsController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'index_subtitle-artists';
        $artistas = Artistas::AllOrderAsc('nombre');
        $router->render('/admin/artists/index',[
            'titulo' => $titulo,
            'artistas' => $artistas
        ]);
    }

    public static function consultaArtistas(){
        isAdmin();
        $consultaArtistas = 'SELECT 
            a.*, 
            n.nivel_en, 
            n.nivel_es,
            e.empresa AS empresa
        FROM 
            artistas a
        INNER JOIN 
            nivel_artistas n ON a.id_nivel = n.id
        INNER JOIN 
            perfil_usuario pu ON a.id_usuario = pu.id_usuario
        INNER JOIN 
            empresa e ON pu.id_empresa = e.id
        ORDER BY 
            a.nombre ASC;
        ';
        $artistas = NivelArtistas::consultarSQL($consultaArtistas);
        echo json_encode($artistas);
    }

    public static function edit(Router $router){
        isAdmin();
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
                    header('Location: /filmtono/artists');
                }
            }
        }
        $router->render('admin/artists/edit',[
            'titulo' => $titulo,
            'alertas' => $alertas,
            'artista' => $artista,
            'niveles' => $niveles,
            'lang' => $lang
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $artista = Artistas::find($id);
        $resultado = $artista->eliminar();
        if($resultado){
            header('Location: /filmtono/artists');
        }
    }
}