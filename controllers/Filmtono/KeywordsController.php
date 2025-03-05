<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Keywords;
use Model\Categorias;
use Model\CategKeyword;

class KeywordsController{
    public static function index(Router $router){
        isAdmin();
        $lang = $_SESSION['lang'];
        $titulo = 'keywords_main-title';
        $categoria = $_GET['category'] ?? null;
        $catId = $_GET['id'] ?? null;
        $categoria = Categorias::where('categoria_en',$categoria);
        if(!$categoria){
            header('Location: /filmtono/categories');
        } else if($lang == 'es'){
            $categoria = $categoria->categoria_es;
        } else {
            $categoria = $categoria->categoria_en;
        }
        $keywords = Keywords::All();
        $router->render('/admin/keywords/index',[
            'titulo' => $titulo,
            'keywords' => $keywords,
            'categoria' => $categoria,
            'catId' => $catId
        ]);
    }

    public static function consultarKeywords(){
        $id = $_GET['id'] ?? null;
        if(!$id){
            header('Location: /filmtono/categories');
        }else{
            $consulta = "SELECT k.id AS id, k.keyword_en, k.keyword_es, c.id AS id_categoria FROM keywords AS k LEFT JOIN categ_keyword AS w ON k.id = w.id_keyword LEFT JOIN categorias AS c ON w.id_categoria = c.id WHERE c.id = ".$id.";";
            $keywords = Keywords::consultarSQL($consulta);
        }
        echo json_encode($keywords);
    }

    public static function new(Router $router){
        isAdmin();
        $lang = $_SESSION['lang'];
        $titulo = 'keywords_new-title';
        $keyword = new Keywords;
        $catId = $_GET['id'] ?? null;
        $categoria = Categorias::where('id',$catId);
        $catName = $categoria->categoria_en;
        if(!$categoria){
            header('Location: /filmtono/categories');
        } else if($lang == 'es'){
            $category = $categoria->categoria_es;
        } else {
            $category = $categoria->categoria_en;
        }
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args=$_POST;
            $keyword->sincronizar($args);
            $alertas = $keyword->validar();
            if(empty($alertas)){
                $existeKeyword = Keywords::where('keyword_en',$_POST['keyword_en']);
                if($existeKeyword){
                    Keywords::setAlerta('error','alert-error-item-exists');
                }else if($existeKeyword = Keywords::where('keyword_es',$_POST['keyword_es'])){
                    Keywords::setAlerta('error','alert-error-item-exists');
                } else if($existeKeyword = Keywords::where('keyword_en',$_POST['keyword_es'])){
                    Keywords::setAlerta('error','alert-error-item-exists');
                } else if($existeKeyword = Keywords::where('keyword_es',$_POST['keyword_en'])){
                    Keywords::setAlerta('error','alert-error-item-exists');
                }
                else{
                    $keyword->guardar();
                    $keyword = Keywords::where('keyword_en',$_POST['keyword_en']);
                    $categKeyword = new CategKeyword;
                    $categKeyword->id_categoria = $catId;
                    $categKeyword->id_keyword = $keyword->id;
                    $resultado = $categKeyword->guardar();
                    $categoria = Categorias::where('id',$catId);
                    $categoria = $categoria->categoria_en;
                    if($resultado){
                        header('Location: /filmtono/categories/keywords?id='.$catId.'&category='.$categoria);
                    }else{
                        Keywords::setAlerta('error','alert-error');
                    }
                }
            }
        }
        $alertas = Keywords::getAlertas();
        $router->render('/admin/keywords/new',[
            'titulo' => $titulo,
            'keyword' => $keyword,
            'alertas' => $alertas,
            'catId' => $catId,
            'categoria' => $categoria,
            'catName' => $catName,
            'category' => $category
        ]);
    }

    public static function edit(Router $router){
        isAdmin();
        $lang = $_SESSION['lang'];
        $titulo = 'keywords_edit-title';
        $id = $_GET['id'] ?? null;
        $catName = $_GET['category'] ?? null;
        $keyword = Keywords::find($id);
        $categoria = Categorias::where('categoria_en',$catName);
        $catId = $categoria->id;
        if($lang == 'es'){
            $category = $categoria->categoria_es;
        } else {
            $category = $categoria->categoria_en;
        }
        if(!$category){
            header('Location: /filmtono/categories');
        }
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $keyword->sincronizar($args);
            $alertas = $keyword->validar();
            if(empty($alertas)){
                
                $resultado = $keyword->guardar();
                if($resultado){
                    header('Location: /filmtono/categories/keywords?id='.$catId.'&category='.$catName);
                }else{
                    Keywords::setAlerta('error','alert-error');
                }
            }
        }
        $alertas = Keywords::getAlertas();
        $router->render('/admin/keywords/edit',[
            'titulo' => $titulo,
            'keyword' => $keyword,
            'alertas' => $alertas,
            'categoria' => $categoria,
            'catId' => $catId,
            'catName' => $catName,
            'category' => $category
        ]);
    }

    public static function delete(){
        isAdmin();
        $category = $_GET['type'] ?? null;
        $category = Categorias::where('categoria_en',$category);
        $id = redireccionar('/filmtono/categories/keywords?id='.$category->id.'&category='.$category->categoria_en);
        if($id){
            $keyword = Keywords::find($id);
            $keyword->eliminar();
            header('Location: /filmtono/categories/keywords?id='.$category->id.'&category='.$category->categoria_en);
        }
    }
}