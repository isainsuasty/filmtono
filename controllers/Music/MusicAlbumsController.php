<?php
namespace Controllers\Music;

use MVC\Router;
use Model\Albums;
use Model\Genres;
use Model\Sellos;
use Model\Empresa;
use Model\Idiomas;
use Model\Artistas;
use Model\Keywords;
use Model\NTMusica;
use Model\Canciones;
use Model\Categorias;
use Model\CancionData;
use Model\AlbumArtista;
use Model\AlbumIdiomas;
use Model\CancionAlbum;
use Model\CancionColab;
use Model\CancionLetra;
use Model\CancionNivel;
use Model\NivelCancion;
use Model\CancionGenero;
use Model\PerfilUsuario;
use Model\UsuarioSellos;
use Model\CancionArtista;
use Model\CancionIdiomas;
use Model\CancionKeywords;
use Model\CancionCategorias;
use Model\CancionEscritores;
use Model\AlbumArtSecundarios;
use Model\UsuarioAlbumArtista;
use Model\CancionGenSecundarios;
use Model\CancionSelloPropiedad;
use Model\CancionEscritorPropiedad;

class MusicAlbumsController{
    public static function index(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $albums = Albums::whereAll('id_usuario', $id);
        $titulo = 'music_main_title';
        $singles = 'SELECT c.id FROM canciones c LEFT JOIN 
                canc_album cal ON c.id = cal.id_cancion 
            WHERE
                c.id_usuario = '.$id.' AND 	cal.id_cancion IS NULL;';
        $singles = Canciones::consultarSQL($singles);
        $router->render('music/albums/index',[
            'titulo' => $titulo,
            'albums' => $albums,
            'singles' => $singles
        ]);
    }

    public static function consultaAlbumes(){
        isMusico();
        $id = $_SESSION['id'];
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
        WHERE 
            al.id_usuario = '.$id.'
        ORDER BY 
            al.id DESC;
        ';
        $albums = UsuarioAlbumArtista::consultarSQL($albums);
        echo json_encode($albums);
    }

    public static function current(Router $router){
        isMusico();
        $albumId = redireccionar('/music/albums');
        $album = Albums::find($albumId);
        if(!$album){
            header('Location: /music/albums');
        }
        $artistaId = AlbumArtista::where('id_albums',$album->id);
        $artista = Artistas::find($artistaId->id_artistas);
        $art_secundarios = AlbumArtSecundarios::where('id_albums',$album->id);
        $albumIdiomas = AlbumIdiomas::whereAll('id_album', $album->id);
        $idiomas = [];
  
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
        $router->render('music/albums/current',[
            'titulo' => $titulo,
            'album' => $album,
            'songs' => $songs,
            'artista' => $artista,
            'art_secundarios' => $art_secundarios,
            'idiomas' => $idiomas
        ]);
    }

    public static function new(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $lang = $_SESSION['lang'] ?? 'en';
        $artistas = Artistas::whereOrdered('id_usuario', $id, 'nombre');
        $usuariosellos = UsuarioSellos::whereAll('id_usuario', $id);
        $sellos = array();
        foreach($usuariosellos as $usuarioSello){
            $sello = Sellos::find($usuarioSello->id_sellos);
            $sellos[] = $sello;
        }

        $titulo = 'music_albums_new';
        $album = new Albums;
        $idiomas = Idiomas::AllOrderAsc('idioma_en');
        $tipoUsuario = NTMusica::where('id_usuario', $id);
        $alertas = [];
        $albumArtSecundarios = new AlbumArtSecundarios;
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id); 
        $selectedLanguages = [];
        $selectedArtistId = null;

        if($lang == 'en'){
            $idioma = Idiomas::AllOrderAsc('idioma_en');
        }else{
            $idioma = Idiomas::AllOrderAsc('idioma_es');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $album ->sincronizar($_POST);
            $albumArtSecundarios->artistas = $_POST['art-secundarios'];
            $album->id_usuario = $_SESSION['id'];
            $alertas = $album->validarAlbum();

            if (!isset($_POST['artistas']) || $_POST['artistas'] === '0' || trim($_POST['artistas']) === '') {
                $alertas = Artistas::setAlerta('error', 'music_albums_artist_alert-required');
            }
            $alertas = Artistas::getAlertas();

            if(empty($_POST['selectedLanguages'])){
                Idiomas::setAlerta('error','music_albums_languages_alert-required');
            }
            $alertas = Idiomas::getAlertas();
            
            if(empty($alertas)){
                if($tipoUsuario->id_nivel != 3){
                    if(empty($_POST['sello'])){
                        $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                        $artista = Artistas::where('id', $_POST['artistas']);
                        $album->sello = $empresa->empresa.' - '.$artista->nombre;
                    }else{
                        $sello = Sellos::where('id', $_POST['sello']);
                        $album->sello = $sello->nombre;
                    }
                }else{
                    $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                    $album->sello = $empresa->empresa;
                }
    
                //buscar si existe el UPC
                $upc = Albums::where('upc', $_POST['upc']);
                if($upc){
                    $alertas['error'][] = tt('music_albums_upc_exists');
                }
                
                //guardar la imagen de portada en la carpeta de portadas
                $directorio = __DIR__.'/../../public/portadas/';
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }

                $nombrePortada = null;

                // Check if the file was uploaded successfully
                if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
                    $nombrePortada = md5(uniqid(rand(), true)) . '.jpg';
                    move_uploaded_file($_FILES['portada']['tmp_name'], $directorio . '/' . $nombrePortada);
                    $album->portada = $nombrePortada;
                } else {
                    $album->portada = 'default-cover.webp';
                }

                $album->guardar();

                //Buscar el álbum recién creado
                $album = Albums::where('upc', $_POST['upc']);

                //Asignar el artista principal al album
                $albumArtista = new AlbumArtista;
                $albumArtista->id_albums = $album->id;
                $albumArtista->id_artistas = $_POST['artistas'];
                $albumArtista->guardar();

                if(!empty($_POST['art-secundarios'])){
                    //Asignar los artistas secundarios al album
                    $albumArtSecundarios = new AlbumArtSecundarios;
                    $albumArtSecundarios->id_albums = $album->id;
                    $albumArtSecundarios->artistas = $_POST['art-secundarios'];
                    $albumArtSecundarios->guardar();
                }

                //guardar los idiomas del album
                $idIdiomas = explode(',', $_POST['selectedLanguages']);
                //save each language in the album
                foreach($idIdiomas as $idIdioma){
                    $albumIdioma = new AlbumIdiomas;
                    $albumIdioma->id_album = $album->id;
                    $albumIdioma->id_idioma = $idIdioma;
                    $albumIdioma->guardar();
                }

                header('Location: /music/albums');
            }
        }

        $alertas = Albums::getAlertas();

        $router->render('music/albums/new',[
            'titulo' => $titulo,
            'album' => $album,
            'artistas' => $artistas,
            'idiomas' => $idiomas,
            'lang' => $lang,
            'tipoUsuario' => $tipoUsuario,
            'sellos' => $sellos,
            'alertas' => $alertas,
            'albumArtSecundarios' => $albumArtSecundarios,
            'selectedLanguages' => $selectedLanguages,
            'selectedArtistId' => $selectedArtistId
        ]);
    }

    public static function edit(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_albums_edit-title';
        $albumId = redireccionar('/music/albums');
        $album = Albums::find($albumId);
        $idiomas = Idiomas::AllOrderAsc('idioma_en');
        $albumArtista = AlbumArtista::where('id_albums',$album->id);
        $albumIdiomas = AlbumIdiomas::whereAll('id_album', $album->id);

        $albumArtSecundarios = AlbumArtSecundarios::where('id_albums',$album->id);
        $artistas = Artistas::whereOrdered('id_usuario', $id, 'nombre');
        $selectedArtist = AlbumArtista::where('id_albums',$album->id);
        $selectedArtistId = $selectedArtist->id_artistas;

        $albumIdiomas = AlbumIdiomas::whereAll('id_album', $album->id);
        $selectedLanguages = []; // This should be fetched based on the album ID
        foreach ($albumIdiomas as $albumIdioma) {
            $selectedLanguages[] = $albumIdioma->id_idioma; // Assuming $albumIdiomas contains records related to the current album
        }
        $albumSello = Sellos::where('nombre', $album->sello);

        $usuariosellos = UsuarioSellos::whereAll('id_usuario', $id);
        $sellos = array();
        foreach($usuariosellos as $usuarioSello){
            $sello = Sellos::find($usuarioSello->id_sellos);
            $sellos[] = $sello;
        }
        $tipoUsuario = NTMusica::where('id_usuario', $id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $album ->sincronizar($_POST);
            if(!empty($_POST['art-secundarios'])){
                $albumArtSecundarios->artistas = $_POST['art-secundarios'];
            }
            $album->id_usuario = $_SESSION['id'];
            $alertas = $album->validarAlbum();
            $perfilUsuario = PerfilUsuario::where('id_usuario', $id); 

            if(empty($alertas)){
                if($tipoUsuario->id_nivel != 3){
                    if(empty($_POST['sello'])){
                        $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                        $artista = Artistas::where('id', $_POST['artistas']);
                        $album->sello = $empresa->empresa.' - '.$artista->nombre;
                    }else{
                        $sello = Sellos::where('id', $_POST['sello']);
                        $album->sello = $sello->nombre;
                    }
                }else{
                    $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                    $album->sello = $empresa->empresa;
                }

                $directorio = __DIR__.'/../../public/portadas/';
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }
                
                $albumOld = Albums::find($albumId);
                $nombrePortada = null;

                if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
                    $nombrePortada = md5(uniqid(rand(), true)) . '.jpg';
                    move_uploaded_file($_FILES['portada']['tmp_name'], $directorio . '/' . $nombrePortada);
                    $album->portada = $nombrePortada;
                    //Eliminar portada anterior
                    if($albumOld->portada !== 'default-cover.webp'){
                        unlink($directorio . '/' . $albumOld->portada);
                    }
                } else {
                    $album->portada = $albumOld->portada;
                }                    
                
                $album->guardar();

                $albumArtista->id_artistas = $_POST['artistas'];
                $albumArtista->guardar();

                if(!empty($_POST['art-secundarios'])){
                    //Asignar los artistas secundarios al album
                    $albumArtSecundarios->artistas = $_POST['art-secundarios'];
                    $albumArtSecundarios->guardar();
                }

                //guardar los idiomas del album
                foreach ($albumIdiomas as $albumIdioma) {
                    $albumIdioma->eliminar();
                }

                $idIdiomas = explode(',', $_POST['selectedLanguages']);
                foreach($idIdiomas as $idIdioma){
                    if($buscarIdioma->id_idioma !== $idIdioma){
                        $albumIdioma = new AlbumIdiomas;
                        $albumIdioma->id_album = $album->id;
                        $albumIdioma->id_idioma = $idIdioma;
                        $albumIdioma->guardar();
                    }
                }

                header('Location: /music/albums');
            }
        }


        $router->render('music/albums/edit',[
            'titulo' => $titulo,
            'album' => $album,
            'lang' => $lang,
            'albumArtSecundarios' => $albumArtSecundarios,
            'sellos' => $sellos,
            'tipoUsuario' => $tipoUsuario,
            'artistas' => $artistas,
            'selectedArtistId' => $selectedArtistId,
            'selectedLanguages' => $selectedLanguages,
            'idiomas' => $idiomas,
            'albumSello' => $albumSello
        ]);
    }

    public static function delete(Router $router){
        isMusico();
        redireccionar('/music/albums');
        $albumId = redireccionar('/music/albums');
        $album = Albums::find($albumId);
        $albumSongs = CancionAlbum::whereAll('id_album', $album->id);
        foreach($albumSongs as $albumSong){
            //search songs by each id
            $song = Canciones::find($albumSong->id_cancion);
            //delete the song
            $song->eliminar();
        }
        $resultado = $album->eliminar();
        if($resultado){
            header('Location: /music/albums');
        }
    }

    public static function newSingle(Router $router){
        isMusico();
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_singles_new-title';
        $single = true;
        $id = $_SESSION['id'];
        $tipoUsuario = NTMusica::where('id_usuario', $id);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id); 
        $song = new Canciones;
        $lang = $_SESSION['lang'] ?? 'en';
        $songColab = new CancionColab;
        $cancionEscritores = new CancionEscritores;
        $cancionLetra = new CancionLetra;
        $cancionNivel = new CancionNivel;
        $cancionArtista = new CancionArtista;
        $cancionGenero = new CancionGenero;
        $cancionEscritorPropiedad = new CancionEscritorPropiedad;
        $cancionSelloPropiedad = new CancionSelloPropiedad;
        $alertas = [];
        
        $selectedCategories = [];
        
        $consultaCategorias = "SELECT c.*,
            ck.id as idcatKey
            FROM categorias c
            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id
            WHERE c.id NOT IN (1)
            GROUP BY c.id
            ORDER BY c.categoria_".$lang.";"
        ;
        
        $categorias = Categorias::consultarSQL($consultaCategorias);

        $niveles = NivelCancion::all();
        
  
        $artistas = Artistas::whereOrdered('id_usuario', $_SESSION['id'], 'nombre');
        
        $generos = Genres::AllOrderAsc('genero_'.$lang);
        
        $selectedGenres = [];


        $consultaKeywords = "SELECT k.* FROM keywords k INNER JOIN categ_keyword ck ON k.id = ck.id_keyword WHERE ck.id_categoria NOT IN (1) ORDER BY keyword_".$lang.";";
        
        $subcategorias = Keywords::consultarSQL($consultaKeywords);
        $selectedSubcategories = [];

        $idiomas = Idiomas::AllOrderAsc('idioma_'.$lang);
        $selectedLanguages = [];

        $usuariosellos = UsuarioSellos::whereAll('id_usuario', $id);
        $sellos = array();
        foreach($usuariosellos as $usuarioSello){
            $sello = Sellos::find($usuarioSello->id_sellos);
            $sellos[] = $sello;
        }

        $temporarySello = '';
        $temporaryArtista = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //debugging($_POST);
            $song->sincronizar($_POST);
            $song->url = getYTVideoId($song->url);
            $song->id_usuario = $id;
            $alertas = $song->validarCancion();

            if(!empty($_POST['sello'])){
                $temporarySello = Sellos::where('id', $_POST['sello']);
                $temporarySello = $temporarySello->nombre;
            }

            if(!empty($_POST['artista'])){
                $temporaryArtista = Artistas::where('id', $_POST['artista']);
                $temporaryArtista = $temporaryArtista->nombre;
            }

            if(!isset($_POST['nivel']) || $_POST['nivel'] === '0' || trim($_POST['nivel']) === ''){
                $alertas = CancionNivel::setAlerta('error', 'music_songs_form-song-level_alert-required');
            }
            $alertas = CancionNivel::getAlertas();

            if(!isset($_POST['artista']) || $_POST['artista'] === '0' || trim($_POST['artista']) === ''){
                $alertas = CancionArtista::setAlerta('error', 'music_songs_form-artist_alert-required');
            }
            $alertas = CancionArtista::getAlertas();

            if(!isset($_POST['genero']) || $_POST['genero'] === '0' || trim($_POST['genero']) === ''){
                $alertas = CancionGenero::setAlerta('error', 'music_songs_form-genre_alert-required');
            }
            $alertas = CancionGenero::getAlertas();

            if(!isset($_POST{'selectedLanguages'}) || $_POST['selectedLanguages'] === '0' || trim($_POST['selectedLanguages']) === ''){
                $alertas = CancionIdiomas::setAlerta('error', 'music_songs-form-language_alert-required');
            }
            $alertas = CancionIdiomas::getAlertas();

            if(!isset($_POST['escritores']) || $_POST['escritores'] === '0' || trim($_POST['escritores']) === ''){
                $alertas = CancionEscritores::setAlerta('error', 'music_songs_form-writers_alert-required');
            }
            $alertas = CancionEscritores::getAlertas();

            if(!isset($_POST['escritor_propiedad']) || $_POST['escritor_propiedad'] === '0' || trim($_POST['escritor_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-required');
            }

            if(!isset($_POST['publisher_propiedad']) || $_POST['publisher_propiedad'] === '0' || trim($_POST['publisher_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-publisher-percent_alert-required');
            }

            $escritorPropiedad = isset($_POST['escritor_propiedad']) ? (int)$_POST['escritor_propiedad'] : 0;
            $publisherPropiedad = isset($_POST['publisher_propiedad']) ? (int)$_POST['publisher_propiedad'] : 0;

            if (($escritorPropiedad + $publisherPropiedad) > 100 || ($escritorPropiedad + $publisherPropiedad) < 100) {
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-total');
            }
            $alertas = CancionEscritorPropiedad::getAlertas();

            if (!isset($_POST['sello_propiedad']) || $_POST['sello_propiedad'] === '0' || trim($_POST['sello_propiedad']) === '') {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-required');
            }
            
            // Check if sello_propiedad exceeds 100
            $selloPropiedad = isset($_POST['sello_propiedad']) ? (int)$_POST['sello_propiedad'] : 0;
            
            if ($selloPropiedad > 100) {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-total');
            }
            $alertas = CancionSelloPropiedad::getAlertas();

            $songColab->sincronizar($_POST);
      
            if(empty($alertas)){
                if($tipoUsuario->id_nivel != 3){
                    if(empty($_POST['sello'])){
                        $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                        $artista = Artistas::where('id', $_POST['artista']);
                        $song->sello = $empresa->empresa.' - '.$artista->nombre;
                    }else{
                        $sello = Sellos::where('id', $_POST['sello']);
                        $song->sello = $sello->nombre;
                    }
                }else{
                    $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                    $song->sello = $empresa->empresa;
                }
                $song->guardar();

                //Buscar la canción recién creada
                $song = Canciones::where('isrc', $_POST['isrc']);
    
                //Guardad nivel de la canción
                $cancionNivel->id_cancion = $song->id;
                $cancionNivel->id_nivel = $_POST['nivel'];
                $cancionNivel->guardar();
    
                //Guardar Artista de la canción
                $cancionArtista->id_cancion = $song->id;
                $cancionArtista->id_artista = $_POST['artista'];
                $cancionArtista->guardar();
    
                //Guardar colaboradores de la canción
                if(!empty($_POST['colaboradores'])){
                    $colaboradores = $_POST['colaboradores'];
                    $songColab->id_cancion = $song->id;
                    $songColab->colaboradores = $colaboradores;
                    $songColab->guardar();
                }
    
                //Guardar género principal de la canción
                $cancionGenero->id_cancion = $song->id;
                $cancionGenero->id_genero = $_POST['genero'];
                $cancionGenero->guardar();
    
                //Guardar géneros secundarios de la canción
                if(!empty($_POST['selectedGenres'])){
                    $generosSecundarios = explode(',', $_POST['selectedGenres']);
                    foreach($generosSecundarios as $generoSecundario){
                        $cancionGenero = new CancionGenSecundarios;
                        $cancionGenero->id_cancion = $song->id;
                        $cancionGenero->id_genero = $generoSecundario;
                        $cancionGenero->guardar();
                    }
                }
                
                //Guardar las categorías de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $categorias = explode(',', $_POST['selectedSubcategories']);
                    
                    foreach($categorias as $categoria){
                        // Get the category related to the subcategory
                        $consultaCategorias = 'SELECT c.* 
                                            FROM categorias c 
                                            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id 
                                            WHERE ck.id_keyword = '.$categoria.' 
                                            GROUP BY c.id';
                        $categorias = Categorias::consultarSQL($consultaCategorias);
                        // Convert array to object (assuming only one result)
                        $categorias = (object)$categorias[0];

                        // Manually check if the combination of id_cancion and id_categoria already exists in canc_categoria table
                        $checkExistenceQuery = 'SELECT * FROM canc_categorias WHERE id_cancion = '.$song->id.' AND id_categoria = '.$categorias->id;
                        $existingCategory = CancionCategorias::consultarSQL($checkExistenceQuery);

                        // If no record is found, proceed with the insertion
                        if (empty($existingCategory)) {
                            $cancionCategoria = new CancionCategorias;
                            $cancionCategoria->id_cancion = $song->id;
                            $cancionCategoria->id_categoria = $categorias->id;
                            $cancionCategoria->guardar();
                        }
                    }
                }
                
                //Guardar las keywords de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $keywords = explode(',', $_POST['selectedSubcategories']);
                    foreach($keywords as $keyword){
                        $cancionKeyword = new CancionKeywords;
                        $cancionKeyword->id_cancion = $song->id;
                        $cancionKeyword->id_keywords = $keyword;
                        $cancionKeyword->guardar();
                    }
                }
                
                //Guardar los idiomas de la canción
                if(!empty($_POST['selectedLanguages'])){
                    $idiomas = explode(',', $_POST['selectedLanguages']);
                    foreach($idiomas as $idioma){
                        $cancionIdioma = new CancionIdiomas;
                        $cancionIdioma->id_cancion = $song->id;
                        $cancionIdioma->id_idioma = $idioma;
                        $cancionIdioma->guardar();
                    }
                }

                $alertas = CancionIdiomas::getAlertas();
                
                //Guardar la letra de la canción
                if(!empty($_POST['letra'])){
                    $cancionLetra->id_cancion = $song->id;
                    $cancionLetra->letra = $_POST['letra'];
                    $cancionLetra->guardar();
                }
    
                //Guardar los escritores de la canción
                $cancionEscritores->id_cancion = $song->id;
                $cancionEscritores->escritores = $_POST['escritores'];
                $cancionEscritores->guardar();
                
                //Guardar la propiedad del escritor y publisher de la canción
                $cancionEscritorPropiedad->id_cancion = $song->id;
                $cancionEscritorPropiedad->escritor_propiedad = $_POST['escritor_propiedad'];
                $cancionEscritorPropiedad->publisher_propiedad = $_POST['publisher_propiedad'];
                $cancionEscritorPropiedad->guardar();
                
                //Guardar la propiedad del sello de la canción
                $cancionSelloPropiedad->id_cancion = $song->id;
                $cancionSelloPropiedad->sello_propiedad = $_POST['sello_propiedad'];
                $cancionSelloPropiedad->guardar();
                
                header('Location: /music/albums');
            }
        }

        $alertas = Canciones::getAlertas();

        $router->render('music/albums/singles/new',[
            'titulo' => $titulo,
            'single' => $single,
            'tipoUsuario' => $tipoUsuario,
            'song' => $song,
            'lang' => $lang,
            'songColab' => $songColab,
            'cancionEscritores' => $cancionEscritores,
            'cancionLetra' => $cancionLetra,
            'cancionNivel' => $cancionNivel,
            'cancionArtista' => $cancionArtista,
            'cancionGenero' => $cancionGenero,
            'cancionEscritorPropiedad' => $cancionEscritorPropiedad,
            'cancionSelloPropiedad' => $cancionSelloPropiedad,
            'categorias' => $categorias,
            'selectedCategories' => $selectedCategories,
            'niveles' => $niveles,
            'artistas' => $artistas,
            'lang' => $lang,
            'generos' => $generos,
            'selectedGenres' => $selectedGenres,
            'subcategorias' => $subcategorias,
            'selectedSubcategories' => $selectedSubcategories,
            'idiomas' => $idiomas,
            'selectedLanguages' => $selectedLanguages,
            'sellos' => $sellos,
            'alertas' => $alertas,
            'temporarySello' => $temporarySello,
            'temporaryArtista' => $temporaryArtista
        ]);
    }

    public static function consultaSingles(){
        isMusico();
        $id = $_SESSION['id'];
        $consultaSingles = 'SELECT 
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
                c.id_usuario = '.$id.' AND 	cal.id_cancion IS NULL
            GROUP BY 
                c.id
            ORDER BY 
                c.id DESC;
        ';
        $singles = CancionData::consultarSQL($consultaSingles);
        echo json_encode($singles);
    }

    public static function editSingle(Router $router){
        isMusico();
        $edit = true;
        $id = $_SESSION['id'];
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_singles_edit-title';
        $singleId = redireccionar('/music/albums');
        $alertas = [];
        $single = true;
        $tipoUsuario = NTMusica::where('id_usuario', $id);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id);
        $song = Canciones::find($singleId);
        $songColab = CancionColab::where('id_cancion', $song->id);
        $cancionEscritores = CancionEscritores::where('id_cancion', $song->id);
        $cancionLetra = CancionLetra::where('id_cancion', $song->id);
        $cancionNivel = CancionNivel::where('id_cancion', $song->id);
        $cancionArtista = CancionArtista::where('id_cancion', $song->id);
        $cancionGenero = CancionGenero::where('id_cancion', $song->id);
        $cancionEscritorPropiedad = CancionEscritorPropiedad::where('id_cancion', $song->id);
        $cancionSelloPropiedad = CancionSelloPropiedad::where('id_cancion', $song->id);

        $niveles = NivelCancion::all();

        $artistas = Artistas::whereOrdered('id_usuario', $_SESSION['id'], 'nombre');

        $generos = Genres::AllOrderAsc('genero_'.$lang);

        $selectedGenres = [];
        $generosSecundarios = CancionGenSecundarios::whereAll('id_cancion', $song->id);
        foreach ($generosSecundarios as $generoSecundario) {
            $selectedGenres[] = $generoSecundario->id_genero;
        }

        $selectedCategories = [];
        $consultaCategorias = "SELECT c.*,
            ck.id as idcatKey
            FROM categorias c
            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id
            WHERE c.id NOT IN (1)
            GROUP BY c.id
            ORDER BY c.categoria_".$lang.";"
        ;
        $categorias = Categorias::consultarSQL($consultaCategorias);

        $cancionCategorias = CancionCategorias::whereAll('id_cancion', $song->id);
        foreach ($cancionCategorias as $cancionCategoria) {
            $selectedCategories[] = $cancionCategoria->id_categoria;
        }

        $selectedSubcategories = [];
        
        $consultaKeywords = "SELECT k.* FROM keywords k INNER JOIN categ_keyword ck ON k.id = ck.id_keyword WHERE ck.id_categoria NOT IN (1) ORDER BY keyword_".$lang.";";
        
        $subcategorias = Keywords::consultarSQL($consultaKeywords);

        $cancionKeywords = CancionKeywords::whereAll('id_cancion', $song->id);
        foreach ($cancionKeywords as $cancionKeyword) {
            $selectedSubcategories[] = $cancionKeyword->id_keywords;
        }

        $idiomas = Idiomas::AllOrderAsc('idioma_'.$lang);
        $selectedLanguages = [];
        
        $cancionIdiomas = CancionIdiomas::whereAll('id_cancion', $song->id);
        foreach ($cancionIdiomas as $cancionIdioma) {
            $selectedLanguages[] = $cancionIdioma->id_idioma;
        }

        $cancionSello = Sellos::where('nombre', $song->sello);
        $usuarioSellos = UsuarioSellos::whereAll('id_usuario', $id);
        $sellos = array();
        foreach($usuarioSellos as $usuarioSello){
            $sello = Sellos::find($usuarioSello->id_sellos);
            $sellos[] = $sello;
        }

        $artistaEdit = Artistas::where('id', $cancionArtista->id_artista);
        $artistaEdit = $artistaEdit->nombre;
        //debugging($artista);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $song->sincronizar($_POST);
            $song->id_usuario = $id;
            $alertas = $song->validarCancion();

            if(!isset($_POST['nivel']) || $_POST['nivel'] === '0' || trim($_POST['nivel']) === ''){
                $alertas = CancionNivel::setAlerta('error', 'music_songs_form-song-level_alert-required');
            }
            $alertas = CancionNivel::getAlertas();

            if(!isset($_POST['artista']) || $_POST['artista'] === '0' || trim($_POST['artista']) === ''){
                $alertas = CancionArtista::setAlerta('error', 'music_songs_form-artist_alert-required');
            }
            $alertas = CancionArtista::getAlertas();

            if(!isset($_POST['genero']) || $_POST['genero'] === '0' || trim($_POST['genero']) === ''){
                $alertas = CancionGenero::setAlerta('error', 'music_songs_form-genre_alert-required');
            }
            $alertas = CancionGenero::getAlertas();

            if(!isset($_POST{'selectedLanguages'}) || $_POST['selectedLanguages'] === '0' || trim($_POST['selectedLanguages']) === ''){
                $alertas = CancionIdiomas::setAlerta('error', 'music_songs-form-language_alert-required');
            }
            $alertas = CancionIdiomas::getAlertas();

            if(!isset($_POST['escritores']) || $_POST['escritores'] === '0' || trim($_POST['escritores']) === ''){
                $alertas = CancionEscritores::setAlerta('error', 'music_songs_form-writers_alert-required');
            }
            $alertas = CancionEscritores::getAlertas();

            if(!isset($_POST['escritor_propiedad']) || $_POST['escritor_propiedad'] === '0' || trim($_POST['escritor_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-required');
            }

            if(!isset($_POST['publisher_propiedad']) || $_POST['publisher_propiedad'] === '0' || trim($_POST['publisher_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-publisher-percent_alert-required');
            }

            $escritorPropiedad = isset($_POST['escritor_propiedad']) ? (int)$_POST['escritor_propiedad'] : 0;
            $publisherPropiedad = isset($_POST['publisher_propiedad']) ? (int)$_POST['publisher_propiedad'] : 0;

            if (($escritorPropiedad + $publisherPropiedad) > 100) {
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-total');
            }
            $alertas = CancionEscritorPropiedad::getAlertas();

            if (!isset($_POST['sello_propiedad']) || $_POST['sello_propiedad'] === '0' || trim($_POST['sello_propiedad']) === '') {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-required');
            }

            // Check if sello_propiedad exceeds 100
            $selloPropiedad = isset($_POST['sello_propiedad']) ? (int)$_POST['sello_propiedad'] : 0;

            if ($selloPropiedad > 100) {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-total');
            }
            $alertas = CancionSelloPropiedad::getAlertas();

            if($_POST['colaboradores']){
                $songColab->sincronizar($_POST);
            }

            if(empty($alertas)){
                if($tipoUsuario->id_nivel != 3){
                    if(empty($_POST['sello'])){
                        $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                        $artista = Artistas::where('id', $_POST['artista']);
                        $song->sello = $empresa->empresa.' - '.$artista->nombre;
                    }else{
                        $sello = Sellos::where('id', $_POST['sello']);
                        $song->sello = $sello->nombre;
                    }
                }else{
                    $empresa = Empresa::where('id', $perfilUsuario->id_empresa);
                    $song->sello = $empresa->empresa;
                }
                $song->url = getYTVideoId($song->url);

                $song->guardar();
                
                $cancionNivel->id_nivel = $_POST['nivel'];
                $cancionNivel->guardar();

                $cancionArtista->id_artista = $_POST['artista'];
                $cancionArtista->guardar();

                if(!empty($_POST['colaboradores'])){
                    $colaboradores = $_POST['colaboradores'];
                    $songColab->colaboradores = $colaboradores;
                    $songColab->guardar();
                }

                $cancionGenero->id_genero = $_POST['genero'];
                $cancionGenero->guardar();

                $buscarGenerosSecundarios = CancionGenSecundarios::whereAll('id_cancion', $song->id);
                foreach($buscarGenerosSecundarios as $generoSecundario){
                    $generoSecundario->eliminar();
                }

                //Guardar géneros secundarios de la canción
                if(!empty($_POST['selectedGenres'])){
                    $generosSecundarios = explode(',', $_POST['selectedGenres']);
                    foreach($generosSecundarios as $generoSecundario){
                        $cancionGenero = new CancionGenSecundarios;
                        $cancionGenero->id_cancion = $song->id;
                        $cancionGenero->id_genero = $generoSecundario;
                        $cancionGenero->guardar();
                    }
                }

                $buscarCategorias = CancionCategorias::whereAll('id_cancion', $song->id);
                foreach($buscarCategorias as $categoria){
                    $categoria->eliminar();
                }

                //Guardar las categorías de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $categorias = explode(',', $_POST['selectedSubcategories']);
                    
                    foreach($categorias as $categoria){
                        // Get the category related to the subcategory
                        $consultaCategorias = 'SELECT c.* 
                                            FROM categorias c 
                                            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id 
                                            WHERE ck.id_keyword = '.$categoria.' 
                                            GROUP BY c.id';
                        $categorias = Categorias::consultarSQL($consultaCategorias);
                        // Convert array to object (assuming only one result)
                        $categorias = (object)$categorias[0];

                        // Manually check if the combination of id_cancion and id_categoria already exists in canc_categoria table
                        $checkExistenceQuery = 'SELECT * FROM canc_categorias WHERE id_cancion = '.$song->id.' AND id_categoria = '.$categorias->id;
                        $existingCategory = CancionCategorias::consultarSQL($checkExistenceQuery);

                        // If no record is found, proceed with the insertion
                        if (empty($existingCategory)) {
                            $cancionCategoria = new CancionCategorias;
                            $cancionCategoria->id_cancion = $song->id;
                            $cancionCategoria->id_categoria = $categorias->id;
                            $cancionCategoria->guardar();
                        }
                    }
                }


                $buscarKeywords = CancionKeywords::whereAll('id_cancion', $song->id);
                foreach($buscarKeywords as $keyword){
                    $keyword->eliminar();
                }

                //Guardar las keywords de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $keywords = explode(',', $_POST['selectedSubcategories']);
                    foreach($keywords as $keyword){
                        $cancionKeyword = new CancionKeywords;
                        $cancionKeyword->id_cancion = $song->id;
                        $cancionKeyword->id_keywords = $keyword;
                        $cancionKeyword->guardar();
                    }
                }

                $buscarIdiomas = CancionIdiomas::whereAll('id_cancion', $song->id);
                foreach($buscarIdiomas as $idioma){
                    $idioma->eliminar();
                }

                //Guardar los idiomas de la canción
                if(!empty($_POST['selectedLanguages'])){
                    $idiomas = explode(',', $_POST['selectedLanguages']);
                    foreach($idiomas as $idioma){
                        $cancionIdioma = new CancionIdiomas;
                        $cancionIdioma->id_cancion = $song->id;
                        $cancionIdioma->id_idioma = $idioma;
                        $cancionIdioma->guardar();
                    }
                }

                $alertas = CancionIdiomas::getAlertas();

                //Guardar la letra de la canción
                if(!empty($_POST['letra'])){
                    $cancionLetra->letra = $_POST['letra'];
                    $cancionLetra->guardar();
                }

                //Guardar los escritores de la canción
                $cancionEscritores->escritores = $_POST['escritores'];
                $cancionEscritores->guardar();

                //Guardar la propiedad del escritor y publisher de la canción
                $cancionEscritorPropiedad->escritor_propiedad = $_POST['escritor_propiedad'];
                $cancionEscritorPropiedad->publisher_propiedad = $_POST['publisher_propiedad'];
                $cancionEscritorPropiedad->guardar();

                //Guardar la propiedad del sello de la canción
                $cancionSelloPropiedad->sello_propiedad = $_POST['sello_propiedad'];
                $cancionSelloPropiedad->guardar();

                header('Location: /music/albums');
            }
        }
        $alertas = Canciones::getAlertas();

        $router->render('music/albums/singles/edit',[
            'titulo' => $titulo,
            'edit' => $edit,
            'lang' => $lang,
            'alertas' => $alertas,
            'single' => $single,
            'tipoUsuario' => $tipoUsuario,
            'perfilUsuario' => $perfilUsuario,
            'song' => $song,
            'songColab' => $songColab,
            'cancionEscritores' => $cancionEscritores,
            'cancionLetra' => $cancionLetra,
            'cancionNivel' => $cancionNivel,
            'cancionArtista' => $cancionArtista,
            'cancionGenero' => $cancionGenero,
            'cancionEscritorPropiedad' => $cancionEscritorPropiedad,
            'cancionSelloPropiedad' => $cancionSelloPropiedad,
            'niveles' => $niveles,
            'artistas' => $artistas,
            'generos' => $generos,
            'categorias' => $categorias,
            'selectedCategories' => $selectedCategories,
            'selectedGenres' => $selectedGenres,
            'subcategorias' => $subcategorias,
            'selectedSubcategories' => $selectedSubcategories,
            'idiomas' => $idiomas,
            'selectedLanguages' => $selectedLanguages,
            'sellos' => $sellos,
            'cancionSello' => $cancionSello,
            'artistaEdit' => $artistaEdit
        ]);
    }

    public static function deleteSingle(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $singleId = redireccionar('/music/albums');
        $song = Canciones::find($singleId);
        $resultado = $song->eliminar();
        if($resultado){
            header('Location: /music/albums');
        }
    }

    public static function currentSingle(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_single_title';
        $singleId = redireccionar('/music/albums');
        $consultaSong = 'SELECT 
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
                c.id = '.$singleId.' AND c.id_usuario = '.$id.'	
            GROUP BY 
                c.id;
        ';
        $song = CancionData::consultarSQL($consultaSong);
        //convertir el array a objeto
        $song = (object)$song[0];

        $router->render('music/albums/singles/current',[
            'titulo' => $titulo,
            'lang' => $lang,
            'song' => $song
        ]);
    }

    public static function newSong(Router $router){
        isMusico();
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_songs_add-title';
        $single = true;
        $id = $_SESSION['id'];
        $idAlbum = redireccionar('/music/albums');
        $album = Albums::find($idAlbum);
        if($album->id_usuario != $id){
            header('Location: /music/albums');
        }
        $albumArtista = AlbumArtista::where('id_albums', $album->id);
        $artista = Artistas::find($albumArtista->id_artistas);
        $tipoUsuario = NTMusica::where('id_usuario', $id);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id); 
        $song = new Canciones;
        $lang = $_SESSION['lang'] ?? 'en';
        $songColab = new CancionColab;
        $cancionEscritores = new CancionEscritores;
        $cancionLetra = new CancionLetra;
        $cancionNivel = new CancionNivel;
        $cancionGenero = new CancionGenero;
        $cancionEscritorPropiedad = new CancionEscritorPropiedad;
        $cancionSelloPropiedad = new CancionSelloPropiedad;
        $alertas = [];
        
        $selectedCategories = [];
        $consultaCategorias = "SELECT c.*,
            ck.id as idcatKey
            FROM categorias c
            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id
            WHERE c.id NOT IN (1)
            GROUP BY c.id
            ORDER BY c.categoria_".$lang.";"
        ;
        $categorias = Categorias::consultarSQL($consultaCategorias);

        $niveles = NivelCancion::all();
        
  
        $artistas = Artistas::whereOrdered('id_usuario', $_SESSION['id'], 'nombre');
        
        $generos = Genres::AllOrderAsc('genero_'.$lang);
        
        $selectedGenres = [];

        
        $consultaKeywords = "SELECT k.* FROM keywords k INNER JOIN categ_keyword ck ON k.id = ck.id_keyword WHERE ck.id_categoria NOT IN (1) ORDER BY keyword_".$lang.";";
        
        
        $subcategorias = Keywords::consultarSQL($consultaKeywords);
        $selectedSubcategories = [];

        $idiomas = Idiomas::AllOrderAsc('idioma_en');
        $selectedLanguages = [];

        $usuariosellos = UsuarioSellos::whereAll('id_usuario', $id);
        $albumArtista = AlbumArtista::where('id_albums', $idAlbum);
        $artista = Artistas::find($albumArtista->id_artistas);
        $artista = $artista->nombre;
        
        $album = Albums::find($idAlbum);
        $albumSello = $album->sello;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $song->sincronizar($_POST);
            $song->url = getYTVideoId($song->url);
            $song->id_usuario = $id;
            $alertas = $song->validarCancion();

            if(!isset($_POST['nivel']) || $_POST['nivel'] === '0' || trim($_POST['nivel']) === ''){
                $alertas = CancionNivel::setAlerta('error', 'music_songs_form-song-level_alert-required');
            }
            $alertas = CancionNivel::getAlertas();

            if(!isset($_POST['genero']) || $_POST['genero'] === '0' || trim($_POST['genero']) === ''){
                $alertas = CancionGenero::setAlerta('error', 'music_songs_form-genre_alert-required');
            }
            $alertas = CancionGenero::getAlertas();

            if(!isset($_POST{'selectedLanguages'}) || $_POST['selectedLanguages'] === '0' || trim($_POST['selectedLanguages']) === ''){
                $alertas = CancionIdiomas::setAlerta('error', 'music_songs-form-language_alert-required');
            }
            $alertas = CancionIdiomas::getAlertas();

            if(!isset($_POST['escritores']) || $_POST['escritores'] === '0' || trim($_POST['escritores']) === ''){
                $alertas = CancionEscritores::setAlerta('error', 'music_songs_form-writers_alert-required');
            }
            $alertas = CancionEscritores::getAlertas();

            if(!isset($_POST['escritor_propiedad']) || $_POST['escritor_propiedad'] === '0' || trim($_POST['escritor_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-required');
            }

            if(!isset($_POST['publisher_propiedad']) || $_POST['publisher_propiedad'] === '0' || trim($_POST['publisher_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-publisher-percent_alert-required');
            }

            $escritorPropiedad = isset($_POST['escritor_propiedad']) ? (int)$_POST['escritor_propiedad'] : 0;
            $publisherPropiedad = isset($_POST['publisher_propiedad']) ? (int)$_POST['publisher_propiedad'] : 0;

            if (($escritorPropiedad + $publisherPropiedad) > 100 || ($escritorPropiedad + $publisherPropiedad) < 100) {
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-total');
            }
            $alertas = CancionEscritorPropiedad::getAlertas();

            if (!isset($_POST['sello_propiedad']) || $_POST['sello_propiedad'] === '0' || trim($_POST['sello_propiedad']) === '') {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-required');
            }
            
            // Check if sello_propiedad exceeds 100
            $selloPropiedad = isset($_POST['sello_propiedad']) ? (int)$_POST['sello_propiedad'] : 0;
            
            if ($selloPropiedad > 100) {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-total');
            }
            $alertas = CancionSelloPropiedad::getAlertas();

            $songColab->sincronizar($_POST);  

            if(empty($alertas)){
                //debugging($_POST);
                $song->sello = $album->sello;
                $song->guardar();

                //Buscar la canción recién creada
                $song = Canciones::where('isrc', $_POST['isrc']);

                $artista = Artistas::find($albumArtista->id_artistas);
                $cancionArtista = new CancionArtista;
                $cancionArtista->id_cancion = $song->id;
                $cancionArtista->id_artista = $artista->id;
                $cancionArtista->guardar();

                $cancionAlbum = new CancionAlbum;
                $cancionAlbum->id_cancion = $song->id;
                $cancionAlbum->id_album = $idAlbum;
                $cancionAlbum->guardar();
    
                //Guardad nivel de la canción
                $cancionNivel->id_cancion = $song->id;
                $cancionNivel->id_nivel = $_POST['nivel'];
                $cancionNivel->guardar();
    
                //Guardar colaboradores de la canción
                if(!empty($_POST['colaboradores'])){
                    $colaboradores = $_POST['colaboradores'];
                    $songColab->id_cancion = $song->id;
                    $songColab->colaboradores = $colaboradores;
                    $songColab->guardar();
                }
    
                //Guardar género principal de la canción
                $cancionGenero->id_cancion = $song->id;
                $cancionGenero->id_genero = $_POST['genero'];
                $cancionGenero->guardar();
    
                //Guardar géneros secundarios de la canción
                if(!empty($_POST['selectedGenres'])){
                    $generosSecundarios = explode(',', $_POST['selectedGenres']);
                    foreach($generosSecundarios as $generoSecundario){
                        $cancionGenero = new CancionGenSecundarios;
                        $cancionGenero->id_cancion = $song->id;
                        $cancionGenero->id_genero = $generoSecundario;
                        $cancionGenero->guardar();
                    }
                }
                
                //Guardar las categorías de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $categorias = explode(',', $_POST['selectedSubcategories']);
                    
                    foreach($categorias as $categoria){
                        // Get the category related to the subcategory
                        $consultaCategorias = 'SELECT c.* 
                                            FROM categorias c 
                                            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id 
                                            WHERE ck.id_keyword = '.$categoria.' 
                                            GROUP BY c.id';
                        $categorias = Categorias::consultarSQL($consultaCategorias);
                        // Convert array to object (assuming only one result)
                        $categorias = (object)$categorias[0];

                        // Manually check if the combination of id_cancion and id_categoria already exists in canc_categoria table
                        $checkExistenceQuery = 'SELECT * FROM canc_categorias WHERE id_cancion = '.$song->id.' AND id_categoria = '.$categorias->id;
                        $existingCategory = CancionCategorias::consultarSQL($checkExistenceQuery);

                        // If no record is found, proceed with the insertion
                        if (empty($existingCategory)) {
                            $cancionCategoria = new CancionCategorias;
                            $cancionCategoria->id_cancion = $song->id;
                            $cancionCategoria->id_categoria = $categorias->id;
                            $cancionCategoria->guardar();
                        }
                    }
                }


                //Guardar las keywords de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $keywords = explode(',', $_POST['selectedSubcategories']);
                    foreach($keywords as $keyword){
                        $cancionKeyword = new CancionKeywords;
                        $cancionKeyword->id_cancion = $song->id;
                        $cancionKeyword->id_keywords = $keyword;
                        $cancionKeyword->guardar();
                    }
                }
                
                //Guardar los idiomas de la canción
                if(!empty($_POST['selectedLanguages'])){
                    $idiomas = explode(',', $_POST['selectedLanguages']);
                    foreach($idiomas as $idioma){
                        $cancionIdioma = new CancionIdiomas;
                        $cancionIdioma->id_cancion = $song->id;
                        $cancionIdioma->id_idioma = $idioma;
                        $cancionIdioma->guardar();
                    }
                }

                $alertas = CancionIdiomas::getAlertas();
                
                //Guardar la letra de la canción
                if(!empty($_POST['letra'])){
                    $cancionLetra->id_cancion = $song->id;
                    $cancionLetra->letra = $_POST['letra'];
                    $cancionLetra->guardar();
                }
    
                //Guardar los escritores de la canción
                $cancionEscritores->id_cancion = $song->id;
                $cancionEscritores->escritores = $_POST['escritores'];
                $cancionEscritores->guardar();
                
                //Guardar la propiedad del escritor y publisher de la canción
                $cancionEscritorPropiedad->id_cancion = $song->id;
                $cancionEscritorPropiedad->escritor_propiedad = $_POST['escritor_propiedad'];
                $cancionEscritorPropiedad->publisher_propiedad = $_POST['publisher_propiedad'];
                $cancionEscritorPropiedad->guardar();
                
                //Guardar la propiedad del sello de la canción
                $cancionSelloPropiedad->id_cancion = $song->id;
                $cancionSelloPropiedad->sello_propiedad = $_POST['sello_propiedad'];
                $cancionSelloPropiedad->guardar();
                
                header('Location: /music/albums/current?id='.$album->id);
            }
        }

        $alertas = Canciones::getAlertas();

        $router->render('music/albums/songs/new',[
            'titulo' => $titulo,
            'single' => $single,
            'album' => $album,
            'tipoUsuario' => $tipoUsuario,
            'song' => $song,
            'lang' => $lang,
            'songColab' => $songColab,
            'cancionEscritores' => $cancionEscritores,
            'cancionLetra' => $cancionLetra,
            'cancionNivel' => $cancionNivel,
            'cancionGenero' => $cancionGenero,
            'cancionEscritorPropiedad' => $cancionEscritorPropiedad,
            'cancionSelloPropiedad' => $cancionSelloPropiedad,
            'categorias' => $categorias,
            'selectedCategories' => $selectedCategories,
            'niveles' => $niveles,
            'artistas' => $artistas,
            'lang' => $lang,
            'generos' => $generos,
            'selectedGenres' => $selectedGenres,
            'subcategorias' => $subcategorias,
            'selectedSubcategories' => $selectedSubcategories,
            'idiomas' => $idiomas,
            'selectedLanguages' => $selectedLanguages,
            'alertas' => $alertas,
            'artista' => $artista,
            'albumSello' => $albumSello
        ]);
    }

    public static function consultaSongs(){
        isMusico();
        $id = $_SESSION['id'];
        $idAlbum = redireccionar('/music/albums');
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

    public static function editSong(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $edit = true;
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_songs_edit-title';
        $songId = redireccionar('/music/albums');
        $alertas = [];
        $cancionAlbum = CancionAlbum::where('id_cancion', $songId);
        $album = Albums::find($cancionAlbum->id_album);
        $tipoUsuario = NTMusica::where('id_usuario', $id);
        $perfilUsuario = PerfilUsuario::where('id_usuario', $id);
        $song = Canciones::find($songId);
        $songColab = CancionColab::where('id_cancion', $song->id);
        $cancionEscritores = CancionEscritores::where('id_cancion', $song->id);
        $cancionLetra = CancionLetra::where('id_cancion', $song->id);
        $cancionNivel = CancionNivel::where('id_cancion', $song->id);
        $cancionGenero = CancionGenero::where('id_cancion', $song->id);
        $cancionEscritorPropiedad = CancionEscritorPropiedad::where('id_cancion', $song->id);
        $cancionSelloPropiedad = CancionSelloPropiedad::where('id_cancion', $song->id);

        $niveles = NivelCancion::all();

        $generos = Genres::AllOrderAsc('genero_'.$lang);

        $selectedGenres = [];
        $generosSecundarios = CancionGenSecundarios::whereAll('id_cancion', $song->id);
        foreach ($generosSecundarios as $generoSecundario) {
            $selectedGenres[] = $generoSecundario->id_genero;
        }

        $selectedCategories = [];
        
        $consultaCategorias = "SELECT c.*,
            ck.id as idcatKey
            FROM categorias c
            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id
            WHERE c.id NOT IN (1)
            GROUP BY c.id
            ORDER BY c.categoria_".$lang.";"
        ;
        $categorias = Categorias::consultarSQL($consultaCategorias);

        $cancionCategorias = CancionCategorias::whereAll('id_cancion', $song->id);
        foreach ($cancionCategorias as $cancionCategoria) {
            $selectedCategories[] = $cancionCategoria->id_categoria;
        }

        $selectedSubcategories = [];
        
        $consultaKeywords = "SELECT k.* FROM keywords k INNER JOIN categ_keyword ck ON k.id = ck.id_keyword WHERE ck.id_categoria NOT IN (1) ORDER BY keyword_".$lang.";";
        
        $subcategorias = Keywords::consultarSQL($consultaKeywords);

        $cancionKeywords = CancionKeywords::whereAll('id_cancion', $song->id);
        foreach ($cancionKeywords as $cancionKeyword) {
            $selectedSubcategories[] = $cancionKeyword->id_keywords;
        }

        $idiomas = Idiomas::AllOrderAsc('idioma_'.$lang);
        $selectedLanguages = [];
        
        $cancionIdiomas = CancionIdiomas::whereAll('id_cancion', $song->id);
        foreach ($cancionIdiomas as $cancionIdioma) {
            $selectedLanguages[] = $cancionIdioma->id_idioma;
        }

        $idAlbum = cancionAlbum::where('id_cancion', $song->id);
        $idAlbum = $idAlbum->id_album;
        $albumArtista = AlbumArtista::where('id_albums', $idAlbum);
        $artista = Artistas::find($albumArtista->id_artistas);
        $artista = $artista->nombre;
        
        $album = Albums::find($idAlbum);
        $albumSello = $album->sello;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $song->sincronizar($_POST);
            $song->id_usuario = $id;
            $alertas = $song->validarCancion();

            if(!isset($_POST['nivel']) || $_POST['nivel'] === '0' || trim($_POST['nivel']) === ''){
                $alertas = CancionNivel::setAlerta('error', 'music_songs_form-song-level_alert-required');
            }
            $alertas = CancionNivel::getAlertas();

            if(!isset($_POST['genero']) || $_POST['genero'] === '0' || trim($_POST['genero']) === ''){
                $alertas = CancionGenero::setAlerta('error', 'music_songs_form-genre_alert-required');
            }
            $alertas = CancionGenero::getAlertas();

            if(!isset($_POST{'selectedLanguages'}) || $_POST['selectedLanguages'] === '0' || trim($_POST['selectedLanguages']) === ''){
                $alertas = CancionIdiomas::setAlerta('error', 'music_songs-form-language_alert-required');
            }
            $alertas = CancionIdiomas::getAlertas();

            if(!isset($_POST['escritores']) || $_POST['escritores'] === '0' || trim($_POST['escritores']) === ''){
                $alertas = CancionEscritores::setAlerta('error', 'music_songs_form-writers_alert-required');
            }
            $alertas = CancionEscritores::getAlertas();

            if(!isset($_POST['escritor_propiedad']) || trim($_POST['escritor_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-required');
            }

            if(!isset($_POST['publisher_propiedad']) || trim($_POST['publisher_propiedad']) === ''){
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-publisher-percent_alert-required');
            }

            $escritorPropiedad = isset($_POST['escritor_propiedad']) ? (int)$_POST['escritor_propiedad'] : 0;
            $publisherPropiedad = isset($_POST['publisher_propiedad']) ? (int)$_POST['publisher_propiedad'] : 0;

            if (($escritorPropiedad + $publisherPropiedad) > 100 || ($escritorPropiedad + $publisherPropiedad) < 100) {
                $alertas = CancionEscritorPropiedad::setAlerta('error', 'music_songs_form-writers-percent_alert-total');
            }
            $alertas = CancionEscritorPropiedad::getAlertas();

            if (!isset($_POST['sello_propiedad']) || trim($_POST['sello_propiedad']) === '') {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-required');
            }

            // Check if sello_propiedad exceeds 100
            $selloPropiedad = isset($_POST['sello_propiedad']) ? (int)$_POST['sello_propiedad'] : 0;

            if ($selloPropiedad > 100) {
                $alertas = CancionSelloPropiedad::setAlerta('error', 'music_songs-form-phonogram_alert-total');
            }
            $alertas = CancionSelloPropiedad::getAlertas();

            if(!empty($_POST['colaboradores'])){
                $songColab->sincronizar($_POST);
            }

            if(empty($alertas)){
                $song->sello = $album->sello;
                $song->url = getYTVideoId($song->url);

                $song->guardar();
                
                $cancionNivel->id_nivel = $_POST['nivel'];
                $cancionNivel->guardar();


                if(!empty($_POST['colaboradores'])){
                    $colaboradores = $_POST['colaboradores'];
                    $songColab->colaboradores = $colaboradores;
                    $songColab->guardar();
                }

                $cancionGenero->id_genero = $_POST['genero'];
                $cancionGenero->guardar();

                $buscarGenerosSecundarios = CancionGenSecundarios::whereAll('id_cancion', $song->id);
                foreach($buscarGenerosSecundarios as $generoSecundario){
                    $generoSecundario->eliminar();
                }

                //Guardar géneros secundarios de la canción
                if(!empty($_POST['selectedGenres'])){
                    $generosSecundarios = explode(',', $_POST['selectedGenres']);
                    foreach($generosSecundarios as $generoSecundario){
                        $cancionGenero = new CancionGenSecundarios;
                        $cancionGenero->id_cancion = $song->id;
                        $cancionGenero->id_genero = $generoSecundario;
                        $cancionGenero->guardar();
                    }
                }

                $buscarCategorias = CancionCategorias::whereAll('id_cancion', $song->id);
                foreach($buscarCategorias as $categoria){
                    $categoria->eliminar();
                }

                //Guardar las categorías de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $categorias = explode(',', $_POST['selectedSubcategories']);
                    
                    foreach($categorias as $categoria){
                        // Get the category related to the subcategory
                        $consultaCategorias = 'SELECT c.* 
                                            FROM categorias c 
                                            INNER JOIN categ_keyword ck ON ck.id_categoria = c.id 
                                            WHERE ck.id_keyword = '.$categoria.' 
                                            GROUP BY c.id';
                        $categorias = Categorias::consultarSQL($consultaCategorias);
                        // Convert array to object (assuming only one result)
                        $categorias = (object)$categorias[0];

                        // Manually check if the combination of id_cancion and id_categoria already exists in canc_categoria table
                        $checkExistenceQuery = 'SELECT * FROM canc_categorias WHERE id_cancion = '.$song->id.' AND id_categoria = '.$categorias->id;
                        $existingCategory = CancionCategorias::consultarSQL($checkExistenceQuery);

                        // If no record is found, proceed with the insertion
                        if (empty($existingCategory)) {
                            $cancionCategoria = new CancionCategorias;
                            $cancionCategoria->id_cancion = $song->id;
                            $cancionCategoria->id_categoria = $categorias->id;
                            $cancionCategoria->guardar();
                        }
                    }
                }


                $buscarKeywords = CancionKeywords::whereAll('id_cancion', $song->id);
                foreach($buscarKeywords as $keyword){
                    $keyword->eliminar();
                }

                //Guardar las keywords de la canción
                if(!empty($_POST['selectedSubcategories'])){
                    $keywords = explode(',', $_POST['selectedSubcategories']);
                    foreach($keywords as $keyword){
                        $cancionKeyword = new CancionKeywords;
                        $cancionKeyword->id_cancion = $song->id;
                        $cancionKeyword->id_keywords = $keyword;
                        $cancionKeyword->guardar();
                    }
                }

                $buscarIdiomas = CancionIdiomas::whereAll('id_cancion', $song->id);
                foreach($buscarIdiomas as $idioma){
                    $idioma->eliminar();
                }

                //Guardar los idiomas de la canción
                if(!empty($_POST['selectedLanguages'])){
                    $idiomas = explode(',', $_POST['selectedLanguages']);
                    foreach($idiomas as $idioma){
                        $cancionIdioma = new CancionIdiomas;
                        $cancionIdioma->id_cancion = $song->id;
                        $cancionIdioma->id_idioma = $idioma;
                        $cancionIdioma->guardar();
                    }
                }

                $alertas = CancionIdiomas::getAlertas();

                //Guardar la letra de la canción
                if(!empty($_POST['letra'])){
                    $cancionLetra->letra = $_POST['letra'];
                    $cancionLetra->guardar();
                }

                //Guardar los escritores de la canción
                $cancionEscritores->escritores = $_POST['escritores'];
                $cancionEscritores->guardar();

                //Guardar la propiedad del escritor y publisher de la canción
                $cancionEscritorPropiedad->escritor_propiedad = $_POST['escritor_propiedad'];
                $cancionEscritorPropiedad->publisher_propiedad = $_POST['publisher_propiedad'];
                $cancionEscritorPropiedad->guardar();

                //Guardar la propiedad del sello de la canción
                $cancionSelloPropiedad->sello_propiedad = $_POST['sello_propiedad'];
                $cancionSelloPropiedad->guardar();

                header('Location: /music/albums/current?id='.$album->id);
            }
        }

        $alertas = Canciones::getAlertas();

        $router->render('music/albums/songs/edit',[
            'titulo' => $titulo,
            'edit' => $edit,
            'lang' => $lang,
            'alertas' => $alertas,
            'album' => $album,
            'tipoUsuario' => $tipoUsuario,
            'perfilUsuario' => $perfilUsuario,
            'song' => $song,
            'songColab' => $songColab,
            'cancionEscritores' => $cancionEscritores,
            'cancionLetra' => $cancionLetra,
            'cancionNivel' => $cancionNivel,
            'cancionGenero' => $cancionGenero,
            'cancionEscritorPropiedad' => $cancionEscritorPropiedad,
            'cancionSelloPropiedad' => $cancionSelloPropiedad,
            'niveles' => $niveles,
            'generos' => $generos,
            'categorias' => $categorias,
            'selectedCategories' => $selectedCategories,
            'selectedGenres' => $selectedGenres,
            'subcategorias' => $subcategorias,
            'selectedSubcategories' => $selectedSubcategories,
            'idiomas' => $idiomas,
            'selectedLanguages' => $selectedLanguages,
            'artista' => $artista,
            'albumSello' => $albumSello
        ]);
    }

    public static function deleteSong(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $songId = redireccionar('/music/albums');
        $album = CancionAlbum::where('id_cancion', $songId);
        $albumId = $album->id_album;
        $song = Canciones::find($songId);
        $resultado = $song->eliminar();
        if($resultado){
            header('Location: /music/albums/current?id='.$albumId);
        }
    }

    public static function currentSong(Router $router){
        isMusico();
        $id = $_SESSION['id'];
        $lang = $_SESSION['lang'] ?? 'en';
        $titulo = 'music_songs_current_title';
        $songId = redireccionar('/music/albums');

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
        $albumID = CancionAlbum::where('id_cancion', $song->id);
        $album = Albums::find($albumID->id_album);
        $albumId = $album->id;

        $router->render('music/albums/songs/current',[
            'titulo' => $titulo,
            'lang' => $lang,
            'song' => $song,
            'album' => $album,
            'albumId' => $albumId
        ]);
    }

    public static function loadSubcategories(){
        //isMusico();
        $idCategoria = $_GET['idCategoria'];
        $lang = $_SESSION['lang'] ?? 'en';
        $consultaSubcategorias = 'SELECT k.*
            FROM keywords k
            INNER JOIN categ_keyword ck ON ck.id_keyword = k.id
            WHERE ck.id_categoria = '.$idCategoria.'
            ORDER BY k.keyword_'.$lang.'
        ;';
        $subcategorias = Keywords::consultarSQL($consultaSubcategorias);
        echo json_encode($subcategorias);
    }
}