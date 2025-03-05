<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Idiomas;

class LanguagesController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 't-languages';
        $idiomas = Idiomas::All();
        $idiomas = count($idiomas);
        $router->render('/admin/languages/index',[
            'titulo' => $titulo,
            'idiomas' => $idiomas
        ]);
    }

    public static function new(Router $router){
        isAdmin();
        $titulo = 'languages_new-title';
        $idioma = new Idiomas();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $idioma->sincronizar($args);
            $alertas = $idioma->validar();
            if(empty($alertas)){
                $existeIdioma = Idiomas::where('idioma_en',$_POST['idioma_en']);
                if($existeIdioma){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else if($existeIdioma = Idiomas::where('idioma_es',$_POST['idioma_es'])){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else if ($existeIdioma = Idiomas::where('idioma_en',$_POST['idioma_es'])){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else if ($existeIdioma = Idiomas::where('idioma_es',$_POST['idioma_en'])){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else{
                $resultado = $idioma->guardar();
                    if($resultado){
                        header('Location: /filmtono/languages');
                    }else{
                        Idiomas::setAlerta('error','alert-error');
                    }
                }
            }
        }

        $alertas = Idiomas::getAlertas();
        $router->render('/admin/languages/new',[
            'titulo' => $titulo,
            'idioma' => $idioma,
            'alertas' => $alertas
        ]);
    }

    public static function consultarIdiomas(){
        isAdmin();
        $idiomas = Idiomas::allOrderAsc('id');
        echo json_encode($idiomas);
    }

    public static function edit(Router $router){
        isAdmin();
        $titulo = 'languages_edit-title';
        $id = $_GET['id'] ?? null;
        if($id){
            $id = filter_var($id, FILTER_VALIDATE_INT);
        }
        $idioma = Idiomas::find($id);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;
            $idioma->sincronizar($args);
            $alertas = $idioma->validar();
            if(empty($alertas)){
                $existeIdioma = Idiomas::where('idioma_en',$_POST['idioma_en']);
                if($existeIdioma){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else if($existeIdioma = Idiomas::where('idioma_es',$_POST['idioma_es'])){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else if ($existeIdioma = Idiomas::where('idioma_en',$_POST['idioma_es'])){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else if ($existeIdioma = Idiomas::where('idioma_es',$_POST['idioma_en'])){
                    Idiomas::setAlerta('error','alert-error-item-exists');
                }else{
                $resultado = $idioma->guardar();
                    if($resultado){
                        header('Location: /filmtono/languages');
                    }else{
                        Idiomas::setAlerta('error','alert-error');
                    }
                }
            }
        }

        $alertas = Idiomas::getAlertas();
        $router->render('/admin/languages/edit',[
            'titulo' => $titulo,
            'idioma' => $idioma,
            'alertas' => $alertas
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        if($id){
            $idioma = Idiomas::find($id);
            $resultado = $idioma->eliminar();
            if($resultado){
                header('Location: /filmtono/languages');
            }
        }
    }
}