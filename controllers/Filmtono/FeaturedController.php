<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Featured;


class FeaturedController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'index_subtitle-featured';
        $featured = Featured::all();
        $router->render('/admin/featured/index',[
            'titulo' => $titulo,
            'featured' => $featured
        ]);
    }

    public static function new(Router $router){
        isAdmin();
        $titulo = 'index_subtitle-featured';
        $featured = new Featured();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $featured->sincronizar($_POST);
            $featured->videoId = getYTVideoId($featured->videoId);
            if(empty($_POST['title'])){
                $alertas = Featured::setAlerta('error', 'admin_featured_form-title_alert-required');
            }
            if(empty($_POST['videoId'])){
                $alertas = Featured::setAlerta('error', 'admin_featured_form-url_alert-required');
            }
            
            $alertas = Featured::getAlertas();
            if(empty($alertas)){
                $featured->guardar();
                header('Location: /filmtono/featured');
            }
        }

        $router->render('/admin/featured/new',[
            'titulo' => $titulo,
            'featured' => $featured,
            'alertas' => $alertas
        ]);
    }

    public static function edit(Router $router){
        isAdmin();
        $titulo = 'index_subtitle-featured';
        $alertas = [];
        $id = redireccionar('/filmtono/featured');
        $featured = Featured::find($id);
        $edit = true;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $featured->sincronizar($_POST);
            $featured->videoId = getYTVideoId($featured->videoId);
            if(empty($_POST['title'])){
                $alertas = Featured::setAlerta('error', 'admin_featured_form-title_alert-required');
            }
            if(empty($_POST['videoId'])){
                $alertas = Featured::setAlerta('error', 'admin_featured_form-url_alert-required');
            }
            
            $alertas = Featured::getAlertas();

            if(empty($alertas)){
                $featured->guardar();
                header('Location: /filmtono/featured');
            }
        }

        $router->render('/admin/featured/edit',[
            'titulo' => $titulo,
            'featured' => $featured,
            'alertas' => $alertas,
            'edit' => $edit
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            $featured = Featured::find($id);
            $resultado = $featured->eliminar();
            if($resultado){
                header('Location: /filmtono/featured');
            }
        }
    }
}