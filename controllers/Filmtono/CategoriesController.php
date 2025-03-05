<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Keywords;
use Model\Categorias;

class CategoriesController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'categories_main-title';
        $categorias = Categorias::All();
        $router->render('/admin/categories/index',[
            'titulo' => $titulo,
            'categorias' => $categorias
        ]);
    }

    public static function consultarCategorias(){
        isAdmin();
        $categorias = Categorias::allOrderAsc('id');
        echo json_encode($categorias);
    }

    public static function new(Router $router){
        isAdmin();
        $titulo = 'categories_new-title';
        $categoria = new Categorias();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $categoria->sincronizar($args);
            $alertas = $categoria->validar();
            if(empty($alertas)){
                $existeCategoria = Categorias::where('categoria_en',$_POST['categoria_en']);
                if($existeCategoria){
                    Categorias::setAlerta('error','alert-error-item-exists');
                }else if($existeCategoria = Categorias::where('categoria_es',$_POST['categoria_es'])){
                    Categorias::setAlerta('error','alert-error-item-exists');
                }else if ($existeCategoria = Categorias::where('categoria_en',$_POST['categoria_es'])){
                    Categorias::setAlerta('error','alert-error-item-exists');
                }else if ($existeCategoria = Categorias::where('categoria_es',$_POST['categoria_en'])){
                    Categorias::setAlerta('error','alert-error-item-exists');
                }else{
                $resultado = $categoria->guardar();
                    if($resultado){
                        header('Location: /filmtono/categories');
                    }else{
                        Categorias::setAlerta('error','alert-error');
                    }
                }
            }
        }

        $alertas = Categorias::getAlertas();
        $router->render('/admin/categories/new',[
            'titulo' => $titulo,
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

    public static function edit(Router $router){
        isAdmin();
        $titulo = 'categories_edit-title';
        $id = redireccionar('/admin/categories');
        $categoria = Categorias::find($id);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $categoria->sincronizar($args);
            $alertas = $categoria->validar();
            if(empty($alertas)){
                $resultado = $categoria->guardar();
                if($resultado){
                    header('Location: /filmtono/categories');
                }else{
                    Categorias::setAlerta('error','alert-error');
                }
            }
        }
        $alertas = Categorias::getAlertas();
        $router->render('/admin/categories/edit',[
            'titulo' => $titulo,
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        if($id){
            $categoria = Categorias::find($id);
            $consulta = 'SELECT keywords.*
            FROM keywords
            INNER JOIN categ_keyword ON keywords.id = categ_keyword.id_keyword
            INNER JOIN categorias ON categ_keyword.id_categoria = categorias.id
            WHERE categorias.id = 11;
            ';
            $keywords = Keywords::consultarSQL($consulta);
            if($keywords){
                foreach($keywords as $keyword){
                    $keyword->eliminar();
                }
            }
            $resultado = $categoria->eliminar();
            if($resultado){
                header('Location: /filmtono/categories');
            }
        }
    }

    public static function activateCategory(){
        //isAdmin();
        $id = $_POST['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        if($id){
            $categoria = Categorias::find($id);
            if($categoria->activo == 1){
                $categoria->activo = 0;
            }else{
                $categoria->activo = 1;
            }
            $resultado = $categoria->guardar();
            echo json_encode(['resultado' => $resultado]);
        }
    }
}