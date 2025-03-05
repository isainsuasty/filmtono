<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Sellos;
use Model\Empresa;
use Model\Usuario;
use Model\NTMusica;
use Model\UserLabels;
use Model\PerfilUsuario;
use Model\UsuarioSellos;

class LabelsController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 't-labels';
        $ntmusica = NTMusica::all();

        $aggregators = NTMusica::whereAll('id_musica', 1);
        $aggregators = count($aggregators);
        $publishers = NTMusica::whereAll('id_musica', 2);
        $publishers = count($publishers);
        $labels = NTMusica::whereAll('id_musica', 3);
        $labels = count($labels);
        $labelsTotal = Sellos::all();
        $labelsTotal = count($labelsTotal);

        $router->render('/admin/labels/index',[
            'titulo' => $titulo,
            'aggregators' => $aggregators,
            'publishers' => $publishers,
            'labels' => $labels,
            'labelsTotal' => $labelsTotal
        ]);
    }

    public static function consultaUsuariosMusica(){
        isAdmin();
        $titulo = 'music_labels-title';
        $ntmusica = NTMusica::all();

        $consultaSellos ="SELECT s.nombre AS labelName, s.creado AS labelDate, s.id AS labelId,
        u.id AS userId, CONCAT(u.nombre, ' ', u.apellido) AS userName,
        e.id AS companyId, e.empresa AS companyName,
        m.id_musica AS musicType
            FROM sellos s
            INNER JOIN usuario_sellos
            INNER JOIN usuarios u
            INNER JOIN empresa e
            INNER JOIN n_t_musica m
            WHERE u.id = usuario_sellos.id_usuario AND s.id = usuario_sellos.id_sellos AND e.id= usuario_sellos.id_empresa AND m.id_usuario = usuario_sellos.id_usuario;";

        $userLabels = UserLabels::consultarSQL($consultaSellos);
        echo json_encode($userLabels);
    }

    public static function current(Router $router){
        isAdmin();
        $titulo = 'admin_label_title';
        $ntmusica = NTMusica::all();
        $id = s($_GET['id']);
        
        $consultaSellos ="SELECT s.nombre AS labelName, s.creado AS labelDate, s.id AS labelId,
        u.id AS userId, CONCAT(u.nombre, ' ', u.apellido) AS userName,
        e.id AS companyId, e.empresa AS companyName,
        m.id_musica AS musicType
            FROM sellos s
            INNER JOIN usuario_sellos us ON s.id = us.id_sellos
            INNER JOIN usuarios u ON u.id = us.id_usuario
            INNER JOIN empresa e On e.id = us.id_empresa
            INNER JOIN n_t_musica m ON m.id_usuario = us.id_usuario
            WHERE s.id={$id};";

        $sello = UserLabels::consultarSQL($consultaSellos);
        //convert to object
        $sello = (object)$sello[0];

        $usuario = Usuario::find($sello->userId);

        $router->render('/admin/labels/current',[
            'titulo' => $titulo,
            'ntmusica' => $ntmusica,
            'sello' => $sello,
            'usuario' => $usuario
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = redireccionar('/filmtono/labels');
        $sellos = Sellos::find($id);
        $resultado = $sellos->eliminar();
        if($resultado){
            header('Location: /filmtono/labels');
        }
    }
}