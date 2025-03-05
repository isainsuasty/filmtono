<?php
namespace Controllers\Filmtono;

use MVC\Router;
use Model\Genres;

class GenresController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'admin_genres_title';
        $generos = Genres::All();

        $router->render('/admin/genres/index',[
            'titulo' => $titulo,
            'generos' => $generos
        ]);
    }

    public static function consultarGeneros(){
        $generos = Genres::allOrderAsc('id');
        echo json_encode($generos);
    }

    public static function new(Router $router){
        isAdmin();
        $genero = new Genres;
        $titulo = 'admin_genres_new_title';
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args=$_POST;
            $genero->sincronizar($args);
            $alertas = $genero->validar();
            if(empty($alertas)){
                $resultado = $genero->guardar();
                if($resultado){
                    header('Location: /filmtono/genres');
                }else{
                    Genres::setAlerta('error','alert-error');
                }
            }
        }
        $router->render('/admin/genres/new',[
            'titulo' => $titulo,
            'genero' => $genero,
            'alertas' => $alertas
        ]);
    }

    public static function edit(Router $router){
        isAdmin();
        $titulo = 'admin_genres_edit_title';
        $id = redireccionar('/admin/genres');
        $genero = Genres::find($id);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $genero->sincronizar($args);
            $alertas = $genero->validar();
            if(empty($alertas)){
                $resultado = $genero->actualizar();
                if($resultado){
                    header('Location: /filmtono/genres');
                }else{
                    Genres::setAlerta('error','alert-error');
                }
            }
        }

        $router->render('/admin/genres/edit',[
            'titulo' => $titulo,
            'genero' => $genero,
            'alertas' => $alertas
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = redireccionar('/filmtono/genres');
        $genero = Genres::find($id);
        $genero->eliminar();
        header('Location: /filmtono/genres');
    }
}