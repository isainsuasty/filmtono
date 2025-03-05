<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Empresa;
use Model\Usuario;
use Model\CTRMusical;
use Model\CTRArtistico;
use Model\PerfilUsuario;
use Model\ContratosUsuario;

class ContractsController{
    public static function index(Router $router){
        isAdmin();
        $titulo = 'contracts_main-title';
        $contratosMusical = CTRMusical::All();
        $contratosArtistico = CTRArtistico::All();

        $router->render('/admin/contracts/index',[
            'titulo' => $titulo,
            'contratosMusical' => $contratosMusical,
            'contratosArtistico' => $contratosArtistico
        ]);
    }

    public static function contratos(Router $router){
        isAdmin();
        $titulo = 'contracts_main-title';
        $contratosMusical = CTRMusical::All();
        $contratosArtistico = CTRArtistico::All();
        $consulta = 'SELECT ctr.id, ctr.fecha, ctr.nombre_doc, u.nombre AS nombre, u.apellido AS apellido, ';
        $consulta .= 'e.empresa AS empresa ';
        $consulta .= 'FROM (SELECT * FROM ctr_musical UNION ALL SELECT * FROM ctr_artistico) AS ctr ';
        $consulta .= 'JOIN perfil_usuario pu ON pu.id_usuario = ctr.id_usuario ';
        $consulta .= 'JOIN usuarios u ON u.id = pu.id_usuario ';
        $consulta .= 'JOIN empresa e ON e.id = pu.id_empresa ORDER BY ctr.fecha DESC;';
        $contratos = ContratosUsuario::consultarSQL($consulta);
        echo json_encode($contratos);
    }
    
    public static function current(Router $router){
        isAdmin();
        $titulo = 'contracts_main-title';
        $id = s($_GET['id']);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $type = s($_GET['type']);

        if($type == 'music'){
            $contrato = CTRMusical::find($id);
        } else {
            $contrato = CTRArtistico::find($id);
        }

        $usuario = Usuario::find($contrato->id_usuario);
        $empresa = Empresa::find($contrato->id_empresa);
       
        $router->render('/admin/contracts/current',[
            'titulo' => $titulo,
            'contrato' => $contrato,
            'type' => $type,
            'usuario' => $usuario,
            'empresa' => $empresa
        ]);
    }

    public static function delete(){
        isAdmin();
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);  
        $type = $_GET['type'];
        if($type == 'music'){  
            $contrato = CTRMusical::find($id);
        } else {
            $contrato = CTRArtistico::find($id);
        }
        //find the file in the folder
        $file = $contrato->nombre_doc;
        $file_route = '../public/contracts/'.$file;
        //delete the file
        unlink($file_route);
        //delete the contract from the database
        $contrato->eliminar();
        header('Location: /filmtono/contracts');
    }
}