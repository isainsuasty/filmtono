<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Promos;

class PromosController{
    public static function index(Router $router){
        isAdmin();

        $promos = Promos::AllOrderDesc('id');
        
        $router->render('/admin/promos/index',[
            'titulo' => 'admin_promos_title',
            'promos' => $promos
        ]);
    }

    public static function new(Router $router){
        isAdmin();
        $promo = new Promos();
        $alertas = [];
 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $promo->sincronizar($_POST);     
            //get the extension of the file
            $ext = pathinfo($_FILES['promos']['name'], PATHINFO_EXTENSION);
            //Set a temporary name for the file
            $promo->promos = $_FILES['promos']['name'];
            //validate the file
            $alertas = $promo->validarPromos();
                if(empty($alertas)){   
                //save the id into the database
                $promo->guardar();
                //get the id of the saved promo
                $promo = Promos::where('promos', $promo->promos);
                
                //set the new name of the file
                $promo->promos = $promo->id . '.' . $ext;
                
                //update the name of the file
                $promo->actualizar();
                //set the new path of the file
                $path = $_SERVER['DOCUMENT_ROOT'] . '/build/img/promos/' . $promo->promos;
                //move the file to the new path
                move_uploaded_file($_FILES['promos']['tmp_name'], $path);
                
                header('Location: /filmtono/promos');
            }
        }
        $alertas = Promos::getAlertas();

        $router->render('/admin/promos/new',[
            'titulo' => 'admin_promos_new-title',
            'promo' => $promo,
            'alertas' => $alertas
        ]);
    }

    public static function edit(Router $router){
        isAdmin();
        $id = redireccionar('/filmtono/promos');
        $promo = Promos::find($id);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $promo->sincronizar($_POST);
            $alertas = $promo->validarPromos();
            if(empty($alertas)){
                //get the file from POST
                $ext = pathinfo($_FILES['promos']['name'], PATHINFO_EXTENSION);
                //set the new name of the file
                $promo->promos = $promo->id . '.' . $ext;
                //update the name of the file                
                $path = $_SERVER['DOCUMENT_ROOT'] . '/build/img/promos/' . $promo->promos;

                if(file_exists($path)){
                    $prueba = unlink($path);
                 } 

                //move the file to the new path
                move_uploaded_file($_FILES['promos']['tmp_name'], $path);

                //update the file in the database
                $promo->actualizar();
                
                header('Location: /filmtono/promos');
            }
        }
        $alertas = Promos::getAlertas();

        $router->render('/admin/promos/edit',[
            'titulo' => 'admin_promos_edit-title',
            'promo' => $promo,
            'alertas' => $alertas
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            $promo = Promos::find($id);
            $resultado = $promo->eliminar();
            if($resultado){
                $path = $_SERVER['DOCUMENT_ROOT'] . '/build/img/promos/' . $promo->promos;
                unlink($path);
                header('Location: /filmtono/promos');
            }
        }
    }
}