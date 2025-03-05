<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\NTMusica;
use Model\CTRMusical;
use Model\CTRArtistico;

class DashboardController{
    public static function admin(Router $router){
        isAdmin();
        $titulo = 'dashboard-title';
        $router->render('/admin/dashboard',[
            'titulo' => 'dashboard-title',
        ]);
    }

    public static function music(Router $router){
        isMusico();
        $usuario = Usuario::find($_SESSION['id']);
        $nivel = NTMusica::where('id_usuario', $_SESSION['id']);                                                                                                               
        $contratoMusical = CTRMusical::where('id_usuario', $_SESSION['id']);
        $contratoArtistico = CTRArtistico::where('id_usuario', $_SESSION['id']);

        $titulo = 'dashboard-title';
        $router->render('music/dashboard',[
            'titulo' => 'dashboard-title',
            'nivel' => $nivel,
            'contratoMusical' => $contratoMusical,
            'contratoArtistico' => $contratoArtistico,
            'usuario' => $usuario
        ]);
    }
}