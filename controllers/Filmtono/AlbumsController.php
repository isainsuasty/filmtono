<?php

namespace Controllers\Filmtono;

use MVC\Router;
use Model\Albums;
use Model\Idiomas;
use Model\Artistas;
use Model\Canciones;
use Model\CancionData;
use Model\AlbumArtista;
use Model\AlbumIdiomas;
use Model\CancionAlbum;
use Model\AlbumArtSecundarios;
use Model\UsuarioAlbumArtista;

class AlbumsController{
    public static function index(Router $router){
        isAdmin();
        $albums = Albums::all();
        $titulo = 'music_main_title';
        $singles = 'SELECT c.id FROM canciones c
            LEFT JOIN
                canc_album cal ON c.id = cal.id_cancion
            WHERE
                cal.id_cancion IS NULL;';
        $singles = Canciones::consultarSQL($singles);
        $router->render('admin/albums/index',[
            'titulo' => $titulo,
            'albums' => $albums,
            'singles' => $singles
        ]);
    }

    public static function consultaAlbumes(){
        //isAdmin();
        $albums = 'SELECT 
            al.*,
            ar.id AS artista_id,
            ar.nombre AS artista_name
        FROM 
            albums al
        LEFT JOIN 
            album_artistas aa ON al.id = aa.id_albums
        LEFT JOIN 
            artistas ar ON aa.id_artistas = ar.id
        ORDER BY 
            al.id DESC;
        ';
        $albums = UsuarioAlbumArtista::consultarSQL($albums);
        echo json_encode($albums);
    }

    public static function current(Router $router){
        isAdmin();
        $albumId = redireccionar('/filmtono/albums');
        $album = Albums::find($albumId);
        $artistaId = AlbumArtista::where('id_albums',$album->id);
        $artista = Artistas::find($artistaId->id_artistas);
        $art_secundarios = AlbumArtSecundarios::where('id_albums',$album->id);
        $albumIdiomas = AlbumIdiomas::whereAll('id_album', $album->id);
        $idiomas = [];
        //debugging($albumIdiomas);
        foreach($albumIdiomas as $albumIdioma){
            $idioma = Idiomas::find($albumIdioma->id_idioma);
            $idiomas[] = $idioma;
            //convertir el array de idiomas en un string
        }
        //convertir el objeto de idiomas en array
        $idiomas = array_map(function($idioma){
            $lang = $_SESSION['lang'] ?? 'en';
            if($lang === 'es'){
                return $idioma->idioma_es;
            }else{
                return $idioma->idioma_en;
            }
        }, $idiomas);

        $idiomas = implode(', ', $idiomas);

        $songs = 'SELECT c.id FROM canciones c
            LEFT JOIN 
                canc_album cal ON c.id = cal.id_cancion 
            WHERE
                cal.id_cancion IS NOT NULL AND cal.id_album = '.$albumId.';
            ';
        $songs = Canciones::consultarSQL($songs);

        if(!$album){
            header('Location: /music/albums');
        }
        $titulo = 'music_album_title';
        $router->render('admin/albums/current',[
            'titulo' => $titulo,
            'album' => $album,
            'songs' => $songs,
            'artista' => $artista,
            'art_secundarios' => $art_secundarios,
            'idiomas' => $idiomas
        ]);
    }

    public static function delete(Router $router){
        isAdmin();
        redireccionar('/filmtono/albums');
        $albumId = redireccionar('/filmtono/albums');
        $album = Albums::find($albumId);
        $resultado = $album->eliminar();
        if($resultado){
            header('Location: /filmtono/albums');
        }
    }

    public static function consultaSingles(){
        isAdmin();
        $singles = 'SELECT 
            c.*,
            ar.id AS artista_id,
            ar.nombre AS artista_name,
            n.nivel_en AS nivel_cancion_es,
            n.nivel_es AS nivel_cancion_en,
            g.genero_es AS genero_es,
            g.genero_en AS genero_en,
            GROUP_CONCAT(DISTINCT cat.categoria_en SEPARATOR \', \') AS categorias_en,
            GROUP_CONCAT(DISTINCT cat.categoria_es SEPARATOR \', \') AS categorias_es,
            col.colaboradores,
            GROUP_CONCAT(DISTINCT gs.genero_en SEPARATOR \', \') AS gensec_en,
            GROUP_CONCAT(DISTINCT gs.genero_es SEPARATOR \', \') AS gensec_es,
            GROUP_CONCAT(DISTINCT i.idioma_en SEPARATOR \', \') AS idioma_en,
            GROUP_CONCAT(DISTINCT i.idioma_es SEPARATOR \', \') AS idioma_es,
            GROUP_CONCAT(DISTINCT ins.keyword_en SEPARATOR \', \') AS instrumentos_en,
            GROUP_CONCAT(DISTINCT ins.keyword_es SEPARATOR \', \') AS instrumentos_es,
            GROUP_CONCAT(DISTINCT k.keyword_en SEPARATOR \', \') AS keywords_en,
            GROUP_CONCAT(DISTINCT k.keyword_es SEPARATOR \', \') AS keywords_es,
            l.letra,
            e.escritores,
            cep.escritor_propiedad,
            cep.publisher_propiedad ,
            csp.sello_propiedad
            FROM canciones c
            LEFT JOIN 
                canc_artista ca ON c.id = ca.id_cancion
            LEFT JOIN
                artistas ar ON ca.id_artista = ar.id
            LEFT JOIN
                canc_nivel cn ON c.id = cn.id_cancion
            LEFT JOIN
                nivel_canc n ON cn.id_nivel = n.id
            LEFT JOIN
                canc_genero cg ON c.id = cg.id_cancion
            LEFT JOIN
                generos g ON cg.id_genero = g.id
            LEFT JOIN
                canc_categorias cc ON c.id = cc.id_cancion
            LEFT JOIN
                categorias cat ON cc.id_categoria = cat.id
            LEFT JOIN 
                canc_colaboradores col ON c.id = col.id_cancion
            LEFT JOIN
                canc_gensecundarios cgs ON c.id = cgs.id_cancion
            left JOIN
                generos gs ON cgs.id_genero = gs.id
            LEFT JOIN 
                canc_idiomas ci ON c.id = ci.id_cancion
            LEFT JOIN 
                idiomas i ON ci.id_idioma = i.id
            LEFT JOIN
                canc_instrumento cins ON c.id = cins.id_cancion
            LEFT JOIN
                keywords ins ON cins.id_instrumento = ins.id
            LEFT JOIN
                canc_keywords ck ON c.id = ck.id_cancion
            LEFT JOIN
                keywords k ON ck.id_keywords = k.id
            LEFT JOIN
                canc_letra l ON c.id = l.id_cancion
            LEFT JOIN
                canc_escritores e ON c.id = e.id_cancion
            LEFT JOIN 
                canc_escritor_propiedad cep ON c.id = cep.id_cancion
            LEFT JOIN 
                canc_sello_propiedad csp ON c.id = csp.id_cancion
            LEFT JOIN 
                canc_album cal ON c.id = cal.id_cancion 
            WHERE
                cal.id_cancion IS NULL
            GROUP BY 
                c.id
            ORDER BY 
                c.id DESC;
        ';
        $singles = CancionData::consultarSQL($singles);
        echo json_encode($singles);
    }

    public static function consultaSongs(){
        isAdmin();
        $idAlbum = redireccionar('/filmtono/albums');
        $consultaSongs = 'SELECT 
             c.*,
             ar.id AS artista_id,
             ar.nombre AS artista_name,
             n.nivel_en AS nivel_cancion_es,
             n.nivel_es AS nivel_cancion_en,
             g.genero_es AS genero_es,
             g.genero_en AS genero_en,
             GROUP_CONCAT(DISTINCT cat.categoria_en SEPARATOR \', \') AS categorias_en,
             GROUP_CONCAT(DISTINCT cat.categoria_es SEPARATOR \', \') AS categorias_es,
             col.colaboradores,
             GROUP_CONCAT(DISTINCT gs.genero_en SEPARATOR \', \') AS gensec_en,
             GROUP_CONCAT(DISTINCT gs.genero_es SEPARATOR \', \') AS gensec_es,
             GROUP_CONCAT(DISTINCT i.idioma_en SEPARATOR \', \') AS idioma_en,
             GROUP_CONCAT(DISTINCT i.idioma_es SEPARATOR \', \') AS idioma_es,
             GROUP_CONCAT(DISTINCT ins.keyword_en SEPARATOR \', \') AS instrumentos_en,
             GROUP_CONCAT(DISTINCT ins.keyword_es SEPARATOR \', \') AS instrumentos_es,
             GROUP_CONCAT(DISTINCT k.keyword_en SEPARATOR \', \') AS keywords_en,
             GROUP_CONCAT(DISTINCT k.keyword_es SEPARATOR \', \') AS keywords_es,
             l.letra,
             e.escritores,
             cep.escritor_propiedad,
             cep.publisher_propiedad ,
             csp.sello_propiedad
             FROM canciones c
             LEFT JOIN 
                 canc_artista ca ON c.id = ca.id_cancion
             LEFT JOIN
                 artistas ar ON ca.id_artista = ar.id
             LEFT JOIN
                 canc_nivel cn ON c.id = cn.id_cancion
             LEFT JOIN
                 nivel_canc n ON cn.id_nivel = n.id
             LEFT JOIN
                 canc_genero cg ON c.id = cg.id_cancion
             LEFT JOIN
                 generos g ON cg.id_genero = g.id
             LEFT JOIN
                 canc_categorias cc ON c.id = cc.id_cancion
             LEFT JOIN
                 categorias cat ON cc.id_categoria = cat.id
             LEFT JOIN 
                 canc_colaboradores col ON c.id = col.id_cancion
             LEFT JOIN
                 canc_gensecundarios cgs ON c.id = cgs.id_cancion
             left JOIN
                 generos gs ON cgs.id_genero = gs.id
             LEFT JOIN 
                 canc_idiomas ci ON c.id = ci.id_cancion
             LEFT JOIN 
                 idiomas i ON ci.id_idioma = i.id
             LEFT JOIN
                 canc_instrumento cins ON c.id = cins.id_cancion
             LEFT JOIN
                 keywords ins ON cins.id_instrumento = ins.id
             LEFT JOIN
                 canc_keywords ck ON c.id = ck.id_cancion
             LEFT JOIN
                 keywords k ON ck.id_keywords = k.id
             LEFT JOIN
                 canc_letra l ON c.id = l.id_cancion
             LEFT JOIN
                 canc_escritores e ON c.id = e.id_cancion
             LEFT JOIN 
                 canc_escritor_propiedad cep ON c.id = cep.id_cancion
             LEFT JOIN 
                 canc_sello_propiedad csp ON c.id = csp.id_cancion
             LEFT JOIN 
                 canc_album cal ON c.id = cal.id_cancion 
             WHERE
                 cal.id_cancion IS NOT NULL AND cal.id_album = '.$idAlbum.'
             GROUP BY 
                 c.id
             ORDER BY 
                 c.id DESC;
        ';
        $songs = CancionData::consultarSQL($consultaSongs);
        echo json_encode($songs);
    }

    public static function currentSingle(Router $router){
        isAdmin();
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_single_title';
        $singleId = redireccionar('/filmtono/albums');
        $consultaSingle = 'SELECT 
            c.*,
            ar.id AS artista_id,
            ar.nombre AS artista_name,
            n.nivel_en AS nivel_cancion_es,
            n.nivel_es AS nivel_cancion_en,
            g.genero_es AS genero_es,
            g.genero_en AS genero_en,
            GROUP_CONCAT(DISTINCT cat.categoria_en SEPARATOR \', \') AS categorias_en,
            GROUP_CONCAT(DISTINCT cat.categoria_es SEPARATOR \', \') AS categorias_es,
            col.colaboradores,
            GROUP_CONCAT(DISTINCT gs.genero_en SEPARATOR \', \') AS gensec_en,
            GROUP_CONCAT(DISTINCT gs.genero_es SEPARATOR \', \') AS gensec_es,
            GROUP_CONCAT(DISTINCT i.idioma_en SEPARATOR \', \') AS idioma_en,
            GROUP_CONCAT(DISTINCT i.idioma_es SEPARATOR \', \') AS idioma_es,
            GROUP_CONCAT(DISTINCT ins.keyword_en SEPARATOR \', \') AS instrumentos_en,
            GROUP_CONCAT(DISTINCT ins.keyword_es SEPARATOR \', \') AS instrumentos_es,
            GROUP_CONCAT(DISTINCT k.keyword_en SEPARATOR \', \') AS keywords_en,
            GROUP_CONCAT(DISTINCT k.keyword_es SEPARATOR \', \') AS keywords_es,
            l.letra,
            e.escritores,
            cep.escritor_propiedad,
            cep.publisher_propiedad ,
            csp.sello_propiedad
            FROM canciones c
            LEFT JOIN 
                canc_artista ca ON c.id = ca.id_cancion
            LEFT JOIN
                artistas ar ON ca.id_artista = ar.id
            LEFT JOIN
                canc_nivel cn ON c.id = cn.id_cancion
            LEFT JOIN
                nivel_canc n ON cn.id_nivel = n.id
            LEFT JOIN
                canc_genero cg ON c.id = cg.id_cancion
            LEFT JOIN
                generos g ON cg.id_genero = g.id
            LEFT JOIN
                canc_categorias cc ON c.id = cc.id_cancion
            LEFT JOIN
                categorias cat ON cc.id_categoria = cat.id
            LEFT JOIN 
                canc_colaboradores col ON c.id = col.id_cancion
            LEFT JOIN
                canc_gensecundarios cgs ON c.id = cgs.id_cancion
            left JOIN
                generos gs ON cgs.id_genero = gs.id
            LEFT JOIN 
                canc_idiomas ci ON c.id = ci.id_cancion
            LEFT JOIN 
                idiomas i ON ci.id_idioma = i.id
            LEFT JOIN
                canc_instrumento cins ON c.id = cins.id_cancion
            LEFT JOIN
                keywords ins ON cins.id_instrumento = ins.id
            LEFT JOIN
                canc_keywords ck ON c.id = ck.id_cancion
            LEFT JOIN
                keywords k ON ck.id_keywords = k.id
            LEFT JOIN
                canc_letra l ON c.id = l.id_cancion
            LEFT JOIN
                canc_escritores e ON c.id = e.id_cancion
            LEFT JOIN 
                canc_escritor_propiedad cep ON c.id = cep.id_cancion
            LEFT JOIN 
                canc_sello_propiedad csp ON c.id = csp.id_cancion
            WHERE
                c.id = '.$singleId.'
            GROUP BY 
                c.id;
        ';
        $song = CancionData::consultarSQL($consultaSingle);
        $song = (object)$song[0];

        $router->render('admin/albums/singles/current',[
            'titulo' => $titulo,
            'song' => $song,
            'lang' => $lang
        ]);
    }

    public static function currentSong(Router $router){
        isAdmin();
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_songs_current_title';
        $songId = redireccionar('/filmtono/albums');
        $consultaSongs = 'SELECT 
             c.*,
             ar.id AS artista_id,
             ar.nombre AS artista_name,
             n.nivel_en AS nivel_cancion_es,
             n.nivel_es AS nivel_cancion_en,
             g.genero_es AS genero_es,
             g.genero_en AS genero_en,
             GROUP_CONCAT(DISTINCT cat.categoria_en SEPARATOR \', \') AS categorias_en,
             GROUP_CONCAT(DISTINCT cat.categoria_es SEPARATOR \', \') AS categorias_es,
             col.colaboradores,
             GROUP_CONCAT(DISTINCT gs.genero_en SEPARATOR \', \') AS gensec_en,
             GROUP_CONCAT(DISTINCT gs.genero_es SEPARATOR \', \') AS gensec_es,
             GROUP_CONCAT(DISTINCT i.idioma_en SEPARATOR \', \') AS idioma_en,
             GROUP_CONCAT(DISTINCT i.idioma_es SEPARATOR \', \') AS idioma_es,
             GROUP_CONCAT(DISTINCT ins.keyword_en SEPARATOR \', \') AS instrumentos_en,
             GROUP_CONCAT(DISTINCT ins.keyword_es SEPARATOR \', \') AS instrumentos_es,
             GROUP_CONCAT(DISTINCT k.keyword_en SEPARATOR \', \') AS keywords_en,
             GROUP_CONCAT(DISTINCT k.keyword_es SEPARATOR \', \') AS keywords_es,
             l.letra,
             e.escritores,
             cep.escritor_propiedad,
             cep.publisher_propiedad ,
             csp.sello_propiedad
             FROM canciones c
             LEFT JOIN 
                 canc_artista ca ON c.id = ca.id_cancion
             LEFT JOIN
                 artistas ar ON ca.id_artista = ar.id
             LEFT JOIN
                 canc_nivel cn ON c.id = cn.id_cancion
             LEFT JOIN
                 nivel_canc n ON cn.id_nivel = n.id
             LEFT JOIN
                 canc_genero cg ON c.id = cg.id_cancion
             LEFT JOIN
                 generos g ON cg.id_genero = g.id
             LEFT JOIN
                 canc_categorias cc ON c.id = cc.id_cancion
             LEFT JOIN
                 categorias cat ON cc.id_categoria = cat.id
             LEFT JOIN 
                 canc_colaboradores col ON c.id = col.id_cancion
             LEFT JOIN
                 canc_gensecundarios cgs ON c.id = cgs.id_cancion
             left JOIN
                 generos gs ON cgs.id_genero = gs.id
             LEFT JOIN 
                 canc_idiomas ci ON c.id = ci.id_cancion
             LEFT JOIN 
                 idiomas i ON ci.id_idioma = i.id
             LEFT JOIN
                 canc_instrumento cins ON c.id = cins.id_cancion
             LEFT JOIN
                 keywords ins ON cins.id_instrumento = ins.id
             LEFT JOIN
                 canc_keywords ck ON c.id = ck.id_cancion
             LEFT JOIN
                 keywords k ON ck.id_keywords = k.id
             LEFT JOIN
                 canc_letra l ON c.id = l.id_cancion
             LEFT JOIN
                 canc_escritores e ON c.id = e.id_cancion
             LEFT JOIN 
                 canc_escritor_propiedad cep ON c.id = cep.id_cancion
             LEFT JOIN 
                 canc_sello_propiedad csp ON c.id = csp.id_cancion
             LEFT JOIN 
                 canc_album cal ON c.id = cal.id_cancion 
             WHERE
                 c.id = '.$songId.'
             GROUP BY 
                 c.id;
        ';
        $song = CancionData::consultarSQL($consultaSongs);
        $song = (object)$song[0];
        $albumId = CancionAlbum::where('id_cancion',$song->id);
        $album = Albums::find($albumId->id_album);

        $router->render('admin/albums/songs/current',[
            'titulo' => $titulo,
            'song' => $song,
            'lang' => $lang,
            'album' => $album
        ]);
    }

    public static function deleteSingle(Router $router){
        isAdmin();
        $singleId = redireccionar('/filmtono/albums');
        $song = Canciones::find($singleId);
        $resultado = $song->eliminar();
        if($resultado){
            header('Location: /filmtono/albums');
        }
    }

    public static function deleteSong(Router $router){
        isAdmin();
        $songId = redireccionar('/filmtono/albums');
        $album = CancionAlbum::where('id_cancion', $songId);
        $albumId = $album->id_album;
        $song = Canciones::find($songId);
        $resultado = $song->eliminar();
        if($resultado){
            header('Location: /filmtono/albums/current?id='.$albumId);
        }
    }
}