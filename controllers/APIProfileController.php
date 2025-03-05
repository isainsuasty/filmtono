<?php

namespace Controllers;

use Model\Sellos;
use Model\Empresa;
use Model\Usuario;
use Model\NTMusica;
use Model\CTRMusical;
use Model\CTRArtistico;
use Model\PerfilUsuario;
use Classes\MusicalContract;
use Classes\ArtisticContract;


class APIProfileController{

    public static function lenguaje(){
        echo json_encode($_SESSION['lang']);
    }

    public static function alerts(){
        //leer el archivo de alerts.json
        $archivo = file_get_contents(__DIR__.'/../alerts.json');
        //convertir el json a un arreglo asociativo
        $archivo = json_decode($archivo, true);

        echo json_encode($archivo);
    }

    public static function contracts(){
        //leer el archivo de contracts.json
        $archivo = file_get_contents(__DIR__.'/../contracts.json');
        //convertir el json a un arreglo asociativo

        $archivo = json_decode($archivo, true);
        echo json_encode($archivo);
    }

    public static function ContratoMusical(){
        $archivo = file_get_contents(__DIR__.'/../views/contracts/c-musical-'.$_SESSION['lang'].'.php');
        
        echo json_encode($archivo);
    }

    public static function ContratoArtistico(){
        $archivo = file_get_contents(__DIR__.'/../views/contracts/c-artistico-'.$_SESSION['lang'].'.php');

        echo json_encode($archivo);
    }

    public static function profileStatus(){
        $respuesta = $_POST['perfil'];
        $usuario = Usuario::find($_SESSION['id']);
        $usuario->perfil = $respuesta;
        $resultado = $usuario->guardar();

        echo json_encode(['resultado' => $resultado]);
    }

    public static function signatures(){
        $respuesta = $_POST;
        $firma = $respuesta['hiddenInput'];
        $tipo = $respuesta['tipo'];
        $usuario = Usuario::find($respuesta['usuario']);
        $perfil = PerfilUsuario::where('id_usuario', $usuario->id);
        $empresa = Empresa::find($perfil->id_empresa);

        if($tipo == 'music'){
            $ctr_music = new CTRMusical();

            $contractPDF = new MusicalContract($usuario->id, $empresa->empresa, $usuario->nombre.' '.$usuario->apellido, $empresa->id_fiscal, $empresa->direccion, $firma, $empresa->pais, $empresa->tel_contacto, $usuario->email, date('d-m-y'), $empresa->id);

            $contractPDF->guardarContrato();

            $ctr_music->id_usuario = $usuario->id;
            $ctr_music->id_empresa = $empresa->id;
            $ctr_music->nombre_doc = $ctr_music->id_usuario.'-'.$ctr_music->id_empresa.'-music-'.date('d-m-y').'.pdf';
            $resultado = $ctr_music->guardar();
            
        } else{
            $ctr_artistic = new CTRArtistico();
            
            $contractPDF = new ArtisticContract($usuario->id, $empresa->empresa, $usuario->nombre.' '.$usuario->apellido, $empresa->id_fiscal, $empresa->direccion, $firma, $empresa->pais, $empresa->tel_contacto, $usuario->email, date('d-m-y'), $empresa->id);
            $contractPDF->guardarContrato();

            $ctr_artistic->id_usuario = $usuario->id;
            $ctr_artistic->id_empresa = $empresa->id;
            $ctr_artistic->nombre_doc = $ctr_artistic->id_usuario.'-'.$ctr_artistic->id_empresa.'-artistic-'.date('d-m-y').'.pdf';
            $resultado = $ctr_artistic->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function getCountries(){
        $paises = file_get_contents(__DIR__.'/../countries.json');
        echo $paises;
    }
}

