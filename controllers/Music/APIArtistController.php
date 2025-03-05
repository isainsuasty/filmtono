<?php
namespace Controllers\Music;

use Model\Artistas;

class APIArtistController{
    public static function artistaNuevo(){

        $respuesta = $_POST['nombre'];
        //eliminar espacios vacios antes y despues
        $respuesta = trim($respuesta);
        $artista = Artistas::where('nombre', $respuesta);
        //convertir a minusculas
        $respuesta = strtolower($respuesta);
        
        if($artista == null || !$artista || $artista == ''){
            $artista = new Artistas();
            $artista->nombre = $respuesta;
            $resultado = $artista->guardar();
        }
        echo json_encode(['resultado' => $resultado]);
    }
}