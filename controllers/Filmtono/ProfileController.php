<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Usuario;

class ProfileController{
    public static function profile(Router $router){
        isAdmin();
        $usuario = Usuario::find($_SESSION['id']);
        $alertas = Usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $args = $_POST;            

            if($args['password'] === ''){
                $args['password'] = $usuario->password;
            } else {
                $args['password'] = password_hash($args['password'],PASSWORD_BCRYPT);
            }          

            $usuario->sincronizar($args);
            unset($usuario->password2);
            $errores = $usuario->validar();

            if(empty($errores)){
                $usuario->guardar();
            }
            Usuario::setAlerta('exito','profile_alert-profile-updated');
        }

        $titulo = 't-profile';
        $router->render('/admin/profile',[
            'titulo' => $titulo,
            'usuario' => $usuario,
            'alertas' => Usuario::getAlertas()
        ]);
    }

    public static function delete(){
        isAdmin();
        $usuario = Usuario::find($_SESSION['id']);
        $_SESSION = [];  
        $usuario->eliminar();  
        
        header('Location: /');
    }
}