<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\ContactoCompra;

class MessagesController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'messages_title';
        $mensajes=ContactoCompra::all();
        $router->render('/admin/messages',[
            'titulo' => $titulo,
            'mensajes' => $mensajes
        ]);
    }

    public static function consultarMensajes(){
        isAdmin();
        $mensajes = ContactoCompra::all();
        
        echo json_encode($mensajes);
    }

    public static function delete(){
        isAdmin();
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        if($id){
            $mensaje = ContactoCompra::find($id);
            $resultado = $mensaje->eliminar();
            if($resultado){
                header('Location: /filmtono/messages');
            }
        }
    }
}