<?php

namespace Controllers;

use MVC\Router;
use Model\Genres;
use Model\Promos;
use Model\Idiomas;
use Model\Artistas;
use Model\Featured;
use Model\Keywords;
use Model\Canciones;
use Classes\Contacto;
use Model\Categorias;
use Model\CancionData;
use Model\CancionNivel;
use Model\NivelCancion;
use Model\CancionGenero;
use Model\ContactoCompra;
use Model\CancionKeywords;
use Model\ArtistSongsPlayer;
use Model\CancionCategorias;
use Model\CancionInstrumento;
use Model\CancionGenSecundarios;
use Model\NivelArtistas;

class PublicController{

    public static function index(Router $router){
        $inicio = true;
        $titulo = 'home_title';
        $promos = Promos::AllOrderDesc('id');
        $artists = Artistas::getOrdered('4', 'id', 'DESC');
        $categorias = Categorias::whereAll('activo', '1');
        $lang = $_SESSION['lang'];

        $router->render('/paginas/index',[
            'inicio' => $inicio,
            'titulo' => $titulo,
            'promos' => $promos,
            'artists' => $artists,
            'categorias' => $categorias,
            'lang' => $lang
        ]);
    }

    public static function filmDirector(Router $router){
        $titulo = 't-film-director';
        $router->render('/paginas/film-director',[
            'titulo' => $titulo
        ]);
    }

    public static function audiovisualProducer(Router $router){
        $titulo = 't-audiovisual-producer';
        $router->render('/paginas/audiovisual-producer',[
            'titulo' => $titulo
        ]);
    }

    public static function musicSupervisor(Router $router){
        $titulo = 't-music-supervisor';
        $router->render('/paginas/music-supervisor',[
            'titulo' => $titulo
        ]);
    }

    public static function contentCreator(Router $router){
        $titulo = 't-content-creator';
        $router->render('/paginas/content-creator',[
            'titulo' => $titulo
        ]);
    }

    public static function categories(Router $router){
        $titulo = 't-categories';
        $router->render('/paginas/categories',[
            'titulo' => $titulo
        ]);
    }

    public static function consultarCategorias(){
        $lang = $_SESSION['lang'];
        $categoriasConsulta = 'SELECT c.*
            FROM categorias c
            WHERE c.id = 1

            UNION

            SELECT c.*
            FROM categorias c
            LEFT JOIN categ_keyword ck ON c.id = ck.id_categoria
            INNER JOIN canc_keywords can ON ck.id_keyword = can.id_keywords
            GROUP BY c.id
            ORDER BY categoria_'.$lang.';';
        $categorias = Categorias::consultarSQL($categoriasConsulta);
        echo json_encode($categorias);
    }

    public static function genres(Router $router){
        $titulo = 't-genres';
        $lang = $_SESSION['lang'];
        $categoria = Categorias::find(1);
        if($lang == 'es'){
            $categoria = $categoria->categoria_es;
        } else {
            $categoria = $categoria->categoria_en;
        }
        $router->render('/paginas/genres',[
            'titulo' => $titulo,
            'categoria' => $categoria
        ]);
    }

    public static function consultarGeneros(){
        $generosConsulta = 'SELECT g.*,
                cg.id_genero
            FROM
                generos g
            RIGHT JOIN
                canc_genero cg ON g.id = cg.id_genero
            GROUP BY g.id
        ;';
        $generos = Genres::consultarSQL($generosConsulta);
        echo json_encode($generos);
    }

    public static function category(Router $router){
        $titulo = 't-category';
        $lang = $_SESSION['lang'];
        $id = $_GET['id'] ?? null;
        if($id){
            $id = filter_var($id, FILTER_VALIDATE_INT);
        }
        $name = $_GET['name'] ?? null;
        if($id !== null){
            $categoria = Categorias::find($id);
        } elseif($name !== null){
            $categoria = Categorias::where('categoria_en',$name);
        } else {
           header('Location: /categories');
        }
        if(!$categoria){
            header('Location: /categories');
        } else if($lang == 'es'){
            $categoria = $categoria->categoria_es;
        } else {
            $categoria = $categoria->categoria_en;
        }
        $router->render('/paginas/category',[
            'titulo' => $titulo,
            'categoria' => $categoria
        ]);
    }

    public static function consultarCategory(){
        $name = $_GET['name'] ?? null;
        $categoria = Categorias::where('categoria_en',$name);
        $id = $_GET['id'] ?? $categoria->id;
        if(!$name && !$id){
            header('Location: /categories');
        }else{
            $consulta = "SELECT k.id AS id,
                    k.keyword_en,
                    k.keyword_es,
                    c.id AS id_categoria
                FROM keywords AS k
                LEFT JOIN categ_keyword AS w ON k.id = w.id_keyword
                LEFT JOIN categorias AS c ON w.id_categoria = c.id
                RIGHT JOIN canc_keywords ck ON k.id = ck.id_keywords
                WHERE c.id = ".$id."
                GROUP BY id";
            $keywords = Keywords::consultarSQL($consulta);
        }
        echo json_encode($keywords);
    }

    public static function about(Router $router){
        $titulo = 't-about';
        $router->render('/paginas/about',[
            'titulo' => $titulo
        ]);
    }

    public static function contact(Router $router){
        $titulo = 't-contact';
        $lang = $_SESSION['lang'];
        $alertas = [];
        $contacto = new ContactoCompra;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $contacto->sincronizar($_POST);
           
            $alertas = $contacto->validar();
            if(empty($alertas)){
                $email = new Contacto($contacto->nombre, $contacto->apellido, $contacto->email, $contacto->pais, $contacto->telefono, $contacto->mensaje);
                $email->enviarMensaje();
                $contacto = [];
                ContactoCompra::setAlerta('exito','t-message-sent');
            }
        }
        $alertas = ContactoCompra::getAlertas();
        $router->render('/paginas/contact',[
            'titulo' => $titulo,
            'lang' => $lang,
            'alertas' => $alertas,
            'contacto' => $contacto
        ]);
    }

    public static function faq(Router $router){
        $titulo = 't-faq';
        $router->render('/paginas/faq',[
            'titulo' => $titulo
        ]);
    }

    public static function terms(Router $router){
        $titulo = 't-terms-conditions';
        $router->render('/paginas/terms-conditions',[
            'titulo' => $titulo
        ]);
    }

    public static function privacy(Router $router){
        $titulo = 't-privacy';
        $router->render('/paginas/privacy',[
            'titulo' => $titulo
        ]);
    }

    public static function songLicensing(Router $router){
        $titulo = 't-song-licensing';
        $router->render('/paginas/song-licensing',[
            'titulo' => $titulo
        ]);
    }

    public static function artists(Router $router){
        $titulo = 'artists_title';
        $artists = Artistas::all();
        $router->render('/paginas/artists',[
            'titulo' => $titulo,
            'artists' => $artists
        ]);
    }

    public static function consultarArtistas(){
        $artists = Artistas::all();
        echo json_encode($artists);
    }

    public static function artist(Router $router){
        $id = redireccionar('/artists');
        $artista = Artistas::find($id);
        $consultaCanciones = 'SELECT c.titulo AS title,
            c.url AS videoId
            FROM canciones c
            INNER JOIN canc_artista ca ON ca.id_artista = '.$id.'
            WHERE c.id = ca.id_cancion AND c.url IS NOT NULL;';
            
        $songs = ArtistSongsPlayer::consultarSQL($consultaCanciones);
        $titulo = 'artist_title';
        $router->render('/paginas/artist',[
            'titulo' => $titulo,
            'artista' => $artista,
            'songs' => $songs
        ]);
    }

    public static function consultarArtista(){
        $id = redireccionar('/artists');
        $consultaCanciones = 'SELECT c.titulo AS title,
            c.url AS videoId
            FROM canciones c
            INNER JOIN canc_artista ca ON ca.id_artista = '.$id.'
            WHERE c.id = ca.id_cancion AND c.url IS NOT NULL;';
            
        $canciones = ArtistSongsPlayer::consultarSQL($consultaCanciones);
        echo json_encode($canciones);
    }

    public static function consultarFeaturedPlaylist(){
        $playlist = Featured::allOrderBy('id','DESC');
        echo json_encode($playlist);
    }

    public static function consultarPlaylistCategoria() {
        $categoryId = $_GET['categoryId'] ?? $categoryId;
        $category = Categorias::find($categoryId);
        $playlist = [];
        $canciones = 'SELECT c.url,
                c.titulo,
		        GROUP_CONCAT(DISTINCT cat.categoria_en SEPARATOR \', \') AS categorias_en,
                GROUP_CONCAT(DISTINCT cat.categoria_es SEPARATOR \', \') AS categorias_es
            FROM canciones c
            LEFT JOIN
                canc_categorias cc ON c.id = cc.id_cancion
            LEFT JOIN
                categorias cat ON cc.id_categoria = cat.id
            WHERE c.url IS NOT NULL AND cat.id = '.$categoryId.'
            GROUP BY c.id
        ;';
        $canciones = CancionData::consultarSQL($canciones);
        foreach ($canciones as $c) {
            $playlist[] = [
                'videoId' => $c->url,      // Asegúrate de que este valor sea compatible con YouTube o el reproductor
                'title'   => $c->titulo    // O cualquier otro campo que quieras mostrar
            ];
        }
        echo json_encode($playlist);
    }    
    

    public static function songsGenre(Router $router){
        $titulo = 'songs_genre_title';
        $lang = $_SESSION['lang'];
        $id = redireccionar('/genres');
        $genero = Genres::find($id);
        $router->render('/paginas/category-songs',[
            'titulo' => $titulo,
            'lang' => $lang,
            'genero' => $genero
        ]);
    }

    public static function consultarSongsGenre(){
        $id = redireccionar('/genres');
        $generos = CancionGenero::whereAll('id_genero',$id);
        $generosSec = CancionGenSecundarios::whereAll('id_genero',$id);
        $songs=[];
        //agregar al array de songs los generos y generos secundarios
        foreach($generos as $genero){
            $song = Canciones::find($genero->id_cancion);
            $songs[] = $song;
        }
        foreach($generosSec as $genero){
            $song = Canciones::find($genero->id_cancion);
            $songs[] = $song;
        }
        echo json_encode($songs);
    }

    public static function songsCategory(Router $router){
        $titulo = 'songs_category_title';
        $lang = $_SESSION['lang'];
        $id = redireccionar('/categories');
        $categoria = keywords::find($id);
        $name = $_GET['name'] ?? null;
        $cid = $_GET['cid'] ?? $id;
        //debugging($categoria);
        $router->render('/paginas/category-songs',[
            'titulo' => $titulo,
            'lang' => $lang,
            'categoria' => $categoria,
            'cid' => $cid,
            'name' => $name
        ]);
    }

    public static function consultarSongsCategory(){
        $id = redireccionar('/categories');
        $cid = $_GET['cid'] ?? $id;
        $category = Categorias::find($cid);
        $songs=[];
        $keyword = CancionKeywords::whereAll('id_keywords',$id);
            foreach($keyword as $key){
                $song = Canciones::find($key->id_cancion);
                $songs[] = $song;
        }
        
        echo json_encode($songs);
    }

    public static function consultarSubcategorias(){
        $categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;
        $subcategorias = [];
        $lang = $_SESSION['lang'];

        $consulta = 'SELECT k.*
                FROM keywords k
                LEFT JOIN
                    categ_keyword ck ON k.id = ck.id_keyword
                RIGHT JOIN
                	canc_keywords cak ON k.id = cak.id_keywords
                WHERE ck.id_categoria = '.$categoryId.'
                GROUP BY k.id
        ;';
        $subcategorias = Keywords::consultarSQL($consulta);

        echo json_encode($subcategorias);
    }

    public static function search(Router $router){
        $titulo = 't-search-songs';
        $lang = $_SESSION['lang'];
        $consultarArtista ='SELECT a.*
            FROM artistas a
            RIGHT JOIN 
                canc_artista ca ON a.id = ca.id_artista
            GROUP BY a.id;'
        ;
        $artistas = Artistas::consultarSQL($consultarArtista);

        $consultaGeneros = 'SELECT g.*
            FROM generos g
            RIGHT JOIN 
                canc_genero cg ON g.id = cg.id_genero
            GROUP BY g.id;'
        ;
        $generos = Genres::consultarSQL($consultaGeneros);
        
        $consultaInstrumentos= "SELECT k.id AS id,
            k.keyword_en,
            k.keyword_es,
            c.id AS id_categoria
            FROM
                keywords AS k
            LEFT JOIN
                categ_keyword AS w ON k.id = w.id_keyword
            LEFT JOIN
                categorias AS c ON w.id_categoria = c.id
            RIGHT JOIN
                canc_keywords ck ON k.id = ck.id_keywords
            WHERE c.id = 2
            GROUP BY k.id
            ORDER BY keyword_".$lang.";"
        ;
        $instrumentos = Keywords::consultarSQL($consultaInstrumentos);

        $consultaIdiomas = "SELECT i.*
            FROM idiomas i
            RIGHT JOIN
                canc_idiomas ci ON i.id = ci.id_idioma
            GROUP BY i.id
            ORDER BY idioma_".$lang.";";
        $idiomas = Idiomas::consultarSQL($consultaIdiomas);
        
        $consultaCategorias = "SELECT cat.*
            FROM categorias cat
            RIGHT JOIN
                categ_keyword ck ON cat.id = ck.id_categoria
            RIGHT JOIN
                canc_keywords cak ON ck.id_keyword = cak.id_keywords
            WHERE cat.id != 2
            GROUP BY cat.id 
            ORDER BY categoria_".$lang.";"
        ;
        $categorias = Categorias::consultarSQL($consultaCategorias);

        $consultaNiveles = 'SELECT n.*
            FROM nivel_canc n
            RIGHT JOIN
                canc_nivel cn ON n.id = cn.id_nivel
            GROUP BY n.id
            ORDER BY id;'
        ;
        $niveles = NivelCancion::consultarSQL($consultaNiveles);

        $consultaNivelesArtistas = 'SELECT n.*
            FROM nivel_artistas n
            RIGHT JOIN
                artistas a ON n.id = a.id_nivel
            RIGHT JOIN
            	canc_artista ca ON a.id = ca.id_artista
            GROUP BY n.id
            ORDER BY id
        ;'
        ;
        $nivelArtistas = NivelArtistas::consultarSQL($consultaNivelesArtistas);


        $router->render('/paginas/search',[
            'titulo' => $titulo,
            'lang' => $lang,
            'artistas' => $artistas,
            'niveles' => $niveles,
            'generos' => $generos,
            'instrumentos' => $instrumentos,
            'idiomas' => $idiomas,
            'categorias' => $categorias,
            'nivelArtistas' => $nivelArtistas
        ]);
    }

    public static function allSongs(){
        $consultaSongs = 'SELECT c.id,
                c.titulo,
                c.url,
                ar.nombre AS artista_name
            FROM canciones c
            LEFT JOIN 
                canc_artista ca ON c.id = ca.id_cancion
            LEFT JOIN
                artistas ar ON ca.id_artista = ar.id
            WHERE c.url IS NOT NULL;'
        ;
        $songs = CancionData::consultarSQL($consultaSongs);
        echo json_encode($songs);
    }

    public static function filterSongs() {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $searchArtista = isset($_GET['artist']) ? $_GET['artist'] : '';
        $searchGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
        $searchInstrument = isset($_GET['instrument']) ? $_GET['instrument'] : '';
        $selectSubcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
        $searchLanguage = isset($_GET['language']) ? $_GET['language'] : '';
        $selectSongLevel = isset($_GET['level']) ? $_GET['level'] : '';
        $selectArtistaLevel = isset($_GET['artistlevel']) ? $_GET['artistlevel'] : '';


        if($searchTerm !== '' || $searchArtista !== '' || $selectSongLevel !== '' || $selectArtistaLevel!== '' || $searchGenre !== '' || $searchInstrument !== '' || $searchLanguage !== '' || $selectSubcategory !== ''){
            $searchTerm = s(filter_var($searchTerm, FILTER_SANITIZE_STRING));
            $consultaTerm = "SELECT DISTINCT c.id,
                c.titulo,
                c.url,
                ar.nombre AS artista_name,
                l.letra,
                k.keyword_en AS keywords_en,
                k.keyword_es AS keywords_es,
                n.nivel_en AS nivel_cancion_es,
                n.nivel_es AS nivel_cancion_en,
                g.genero_es AS genero_es,
                g.genero_en AS genero_en
            FROM canciones c
            LEFT JOIN 
                canc_artista ca ON c.id = ca.id_cancion
            LEFT JOIN
                artistas ar ON ca.id_artista = ar.id
            LEFT JOIN
                canc_letra l ON c.id = l.id_cancion
            LEFT JOIN
                canc_keywords ck ON c.id = ck.id_cancion
            LEFT JOIN
                keywords k ON ck.id_keywords = k.id
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
                canc_idiomas ci ON c.id = ci.id_cancion
            LEFT JOIN 
                idiomas i ON ci.id_idioma = i.id
            LEFT JOIN
                canc_gensecundarios cgs ON c.id = cgs.id_cancion
            LEFT JOIN
                generos gs ON cgs.id_genero = gs.id
            LEFT JOIN
            	nivel_artistas nar ON ar.id_nivel = nar.id
            WHERE c.url IS NOT NULL";

            if($searchTerm !== ''){
                $consultaTerm .= " AND (c.titulo LIKE '%".$searchTerm."%' OR l.letra LIKE '%" . $searchTerm . "%' OR k.keyword_en LIKE '%" . $searchTerm . "%' OR k.keyword_es LIKE '%" . $searchTerm . "%')";
            }           
            
            // Apply the artist filter if specified
            if ($searchArtista != '') {
                $consultaTerm .= " AND ar.id = " . (int)$searchArtista;
            }

            if($selectSongLevel != ''){
                $consultaTerm .= " AND n.id = " . (int)$selectSongLevel;
            }

            if($selectArtistaLevel != ''){
                $consultaTerm .= " AND nar.id = " . (int)$selectArtistaLevel;
            }

            if($searchGenre != ''){
                $consultaTerm .= " AND (g.id = " . (int)$searchGenre. " OR gs.id = " . (int)$searchGenre.")";
            }

            if($searchInstrument != ''){
                $consultaTerm .= " AND ck.id_keywords = " . (int)$searchInstrument;
            }

            if($selectSubcategory != ''){
                $consultaTerm .= " AND (";
                //convertir a array
                $selectSubcategory = explode(",",$selectSubcategory);
                //recorrer array y agregar a la consulta mediante OR menos el ultimo
                for($i = 0; $i < count($selectSubcategory)-1; $i++){
                    $consultaTerm .= " k.id = " . (int)$selectSubcategory[$i] . " OR";
                }
                //agregar el ultimo
                $consultaTerm .= " k.id = " . (int)$selectSubcategory[count($selectSubcategory)-1].")";
            }

            if($searchLanguage != ''){
                $consultaTerm .= " AND i.id = " . (int)$searchLanguage;
            }

            $consultaTerm .= " GROUP BY c.id;";

            $songs = CancionData::consultarSQL($consultaTerm);
        }else{
            $songs = [];
        }
        echo json_encode($songs);  // Return matching songs as JSON
    }
}