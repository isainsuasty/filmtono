<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\PublicController;
use Controllers\DashboardController;
use Controllers\APIProfileController;


use Controllers\Music\CompanyController;
use Controllers\Filmtono\UsersController;
use Controllers\Filmtono\AlbumsController;
use Controllers\Filmtono\GenresController;
use Controllers\Filmtono\LabelsController;
use Controllers\Filmtono\PromosController;
use Controllers\Music\APIArtistController;
use Controllers\Filmtono\ArtistsController;
use Controllers\Filmtono\ProfileController;
use Controllers\Filmtono\APIUsersController;
use Controllers\Filmtono\FeaturedController;

use Controllers\Filmtono\KeywordsController;
use Controllers\Filmtono\MessagesController;
use Controllers\Music\MusicAlbumsController;
use Controllers\Music\MusicLabelsController;
use Controllers\Filmtono\ContractsController;


use Controllers\Filmtono\LanguagesController;
use Controllers\Music\MusicArtistsController;
use Controllers\Music\MusicProfileController;
use Controllers\Filmtono\CategoriesController;


$router = new Router();
session_start();

// Home
$router->get('/', [PublicController::class, 'index']);

// Public categories
$router->get('/categories', [PublicController::class, 'categories']);
$router->get('/api/public/categories', [PublicController::class, 'consultarCategorias']);
$router->get('/category/genres', [PublicController::class, 'genres']);
$router->get('/api/public/genres', [PublicController::class, 'consultarGeneros']);
$router->get('/category', [PublicController::class, 'category']);
$router->get('/api/public/category', [PublicController::class, 'consultarCategory']);

$router->get('/search', [PublicController::class, 'search']);
$router->get('/contact', [PublicController::class, 'contact']);
$router->post('/contact', [PublicController::class, 'contact']);
$router->get('/faq', [PublicController::class, 'faq']);
$router->get('/film-director', [PublicController::class, 'filmDirector']);
$router->get('/music-supervisor', [PublicController::class, 'musicSupervisor']);
$router->get('/audiovisual-producer', [PublicController::class, 'audiovisualProducer']);
$router->get('/content-creator', [PublicController::class, 'contentCreator']);

//Public pages from footer
$router->get('/about', [PublicController::class, 'about']);
$router->get('/terms-conditions', [PublicController::class, 'terms']);
$router->get('/privacy', [PublicController::class, 'privacy']);
$router->get('/song-licensing', [PublicController::class, 'songLicensing']);

//Public songs in categories
$router->get('/category/genre', [PublicController::class, 'songsGenre']);
$router->get('/category/songs', [PublicController::class, 'songsCategory']);
$router->get('/api/public/category/genre', [PublicController::class, 'consultarSongsGenre']);
$router->get('/api/public/category/songs', [PublicController::class, 'consultarSongsCategory']);

// Public artists
$router->get('/artists', [PublicController::class, 'artists']);
$router->get('/api/public/artists', [PublicController::class, 'consultarArtistas']);
$router->get('/artist', [PublicController::class, 'artist']);
$router->get('/api/public/artist/', [PublicController::class, 'consultarArtista']);
$router->get('/api/public/featured-playlist', [PublicController::class, 'consultarFeaturedPlaylist']);
$router->get('/api/public/playlist-category', [PublicController::class, 'consultarPlaylistCategoria']);

//Public songs with search bar
$router->get('/api/public/songs', [PublicController::class, 'allSongs']);
$router->get('/api/public/songs/search', [PublicController::class, 'filterSongs']);

//Auth Usuarios
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/register-music', [AuthController::class, 'registerMusic']);
$router->post('/register-music', [AuthController::class, 'registerMusic']);
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm-account', [AuthController::class, 'confirm']);
$router->get('/forgot-password', [AuthController::class, 'forgot']);
$router->post('/forgot-password', [AuthController::class, 'forgot']);
$router->get('/reset-password', [AuthController::class, 'reset']);
$router->post('/reset-password', [AuthController::class, 'reset']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/complete-register', [AuthController::class, 'completeRegister']);
$router->post('/complete-register', [AuthController::class, 'completeRegister']);

//**----- Dashboard Editoriales/Publishers
$router->get('/music/dashboard', [DashboardController::class, 'music']);
//Profile
$router->get('/music/profile', [MusicProfileController::class, 'index']);
$router->post('/music/profile', [MusicProfileController::class, 'index']);
$router->get('/music/profile/delete', [MusicProfileController::class, 'delete']);

//Music Labels
$router->get('/music/labels', [MusicLabelsController::class, 'index']);
$router->get('/api/music/labels', [MusicLabelsController::class, 'consultarSellos']);
$router->get('/music/labels/new', [MusicLabelsController::class, 'new']);
$router->post('/music/labels/new', [MusicLabelsController::class, 'new']);
$router->get('/music/labels/edit', [MusicLabelsController::class, 'edit']);
$router->post('/music/labels/edit', [MusicLabelsController::class, 'edit']);
$router->get('/music/labels/delete', [MusicLabelsController::class, 'delete']);

//Music Albums
$router->get('/music/albums', [MusicAlbumsController::class, 'index']);
$router->get('/api/music/albums/albums', [MusicAlbumsController::class, 'consultaAlbumes']);
$router->get('/music/albums/current', [MusicAlbumsController::class, 'current']);
$router->get('/music/albums/new', [MusicAlbumsController::class, 'new']);
$router->post('/music/albums/new', [MusicAlbumsController::class, 'new']);
$router->get('/music/albums/edit', [MusicAlbumsController::class, 'edit']);
$router->post('/music/albums/edit', [MusicAlbumsController::class, 'edit']);
$router->get('/music/albums/delete', [MusicAlbumsController::class, 'delete']);

//Music Singles
$router->get('/music/singles/new', [MusicAlbumsController::class, 'newSingle']);
$router->post('/music/singles/new', [MusicAlbumsController::class, 'newSingle']);
$router->get('/api/music/singles', [MusicAlbumsController::class, 'consultaSingles']);
$router->get('/music/singles/edit', [MusicAlbumsController::class, 'editSingle']);
$router->post('/music/singles/edit', [MusicAlbumsController::class, 'editSingle']);
$router->get('/music/singles/delete', [MusicAlbumsController::class, 'deleteSingle']);
$router->get('/music/singles/current', [MusicAlbumsController::class, 'currentSingle']);
$router->get('/api/music/categoriesForm', [MusicAlbumsController::class, 'loadSubcategories']);

//Music Songs
$router->get('/music/albums/song/new', [MusicAlbumsController::class, 'newSong']);
$router->post('/music/albums/song/new', [MusicAlbumsController::class, 'newSong']);
$router->get('/api/music/albums/songs', [MusicAlbumsController::class, 'consultaSongs']);
$router->get('/music/albums/song/current', [MusicAlbumsController::class, 'currentSong']);
$router->get('/music/albums/song/edit', [MusicAlbumsController::class, 'editSong']);
$router->post('/music/albums/song/edit', [MusicAlbumsController::class, 'editSong']);
$router->get('/music/song/delete', [MusicAlbumsController::class, 'deleteSong']);
$router->get('/music/album/songs/current', [MusicAlbumsController::class, 'currentSong']);


//Music Artists
$router->get('/music/artists', [MusicArtistsController::class, 'index']);
$router->get('/music/artists/new', [MusicArtistsController::class, 'new']);
$router->post('/music/artists/new', [MusicArtistsController::class, 'new']);
$router->get('/music/artists/edit', [MusicArtistsController::class, 'edit']);
$router->post('/music/artists/edit', [MusicArtistsController::class, 'edit']);
$router->get('/music/artists/delete', [MusicArtistsController::class, 'delete']);
$router->get('/api/music/artists/artists', [MusicArtistsController::class, 'consultaArtistas']);

//Music contracts
$router->get('/music/company', [CompanyController::class, 'index']);
$router->post('/music/company', [CompanyController::class, 'index']);
$router->get('/music/company/contracts', [CompanyController::class, 'contracts']);
$router->get('/music/company/delete', [CompanyController::class, 'delete']);

//Dashboard Filmtono
$router->get('/filmtono/dashboard', [DashboardController::class, 'admin']);

//Filmtono APIs
$router->get('/api/filmtono/users', [APIUsersController::class, 'usuarios']);
$router->get('/api/filmtono/lenguaje', [APIProfileController::class, 'lenguaje']);
$router->get('/api/filmtono/alerts', [APIProfileController::class, 'alerts']);
$router->get('/api/filmtono/contracts', [APIProfileController::class, 'contracts']);
$router->post('/api/filmtono/signature', [APIProfileController::class, 'signatures']);
$router->get('/api/filmtono/c-musical', [APIProfileController::class, 'contratoMusical']);
$router->get('/api/filmtono/c-artistico', [APIProfileController::class, 'contratoArtistico']);
$router->post('/api/albums/artistasNew', [APIArtistController::class, 'artistaNuevo']);
$router->get('/api/filmtono/messages', [MessagesController::class, 'consultarMensajes']);
$router->get('/api/filmtono/countries', [APIProfileController::class, 'getCountries']);
$router->get('/api/filmtono/albums/songs', [AlbumsController::class, 'consultaSongs']);
$router->get('/api/filmtono/singles', [AlbumsController::class, 'consultaSingles']);
$router->post('/api/filmtono/aprobar-usuario', [APIUsersController::class, 'aprobarUsuario']);
$router->post('/api/filmtono/category/activate', [CategoriesController::class, 'activateCategory']);
$router->get('/api/public/subcategories', [PublicController::class, 'consultarSubcategorias']);


//Filmtono Profile
$router->get('/filmtono/profile', [ProfileController::class, 'profile']);
$router->post('/filmtono/profile', [ProfileController::class, 'profile']);
$router->post('/filmtono/profile/delete', [ProfileController::class, 'delete']);

//Filmtono Promos
$router->get('/filmtono/promos', [PromosController::class, 'index']);
$router->get('/filmtono/promos/new', [PromosController::class, 'new']);
$router->post('/filmtono/promos/new', [PromosController::class, 'new']);
$router->get('/filmtono/promos/edit', [PromosController::class, 'edit']);
$router->post('/filmtono/promos/edit', [PromosController::class, 'edit']);
$router->get('/filmtono/promos/delete', [PromosController::class, 'delete']);

//Filmtono Featured
$router->get('/filmtono/featured', [FeaturedController::class, 'index']);
$router->get('/filmtono/featured/new', [FeaturedController::class, 'new']);
$router->post('/filmtono/featured/new', [FeaturedController::class, 'new']);
$router->get('/filmtono/featured/edit', [FeaturedController::class, 'edit']);
$router->post('/filmtono/featured/edit', [FeaturedController::class, 'edit']);
$router->get('/filmtono/featured/delete', [FeaturedController::class, 'delete']);

//Filmtono Users
$router->get('/filmtono/users', [UsersController::class, 'index']);
$router->get('/filmtono/users/current', [UsersController::class, 'current']);
$router->get('/filmtono/users/new', [UsersController::class, 'new']);
$router->post('/filmtono/users/new', [UsersController::class, 'new']);
$router->get('/filmtono/users/delete', [UsersController::class, 'delete']);

//Filmtono Labels
$router->get('/filmtono/labels', [LabelsController::class, 'index']);
$router->get('/api/filmtono/labels', [LabelsController::class, 'consultaUsuariosMusica']);
$router->get('/filmtono/labels/current', [LabelsController::class, 'current']);
$router->get('/filmtono/labels/delete', [LabelsController::class, 'delete']);

//Filmtono Categories
$router->get('/filmtono/categories', [CategoriesController::class, 'index']);
$router->get('/api/filmtono/categories', [CategoriesController::class, 'consultarCategorias']);
$router->get('/filmtono/categories/new', [CategoriesController::class, 'new']);
$router->post('/filmtono/categories/new', [CategoriesController::class, 'new']);
$router->get('/filmtono/categories/edit', [CategoriesController::class, 'edit']);
$router->post('/filmtono/categories/edit', [CategoriesController::class, 'edit']);
$router->get('/filmtono/categories/delete', [CategoriesController::class, 'delete']);

//Filmtono Albums
$router->get('/filmtono/albums', [AlbumsController::class, 'index']);
$router->get('/api/filmtono/albums/albums', [AlbumsController::class, 'consultaAlbumes']);
$router->get('/filmtono/albums/delete', [AlbumsController::class, 'delete']);
$router->get('/filmtono/albums/current', [AlbumsController::class, 'current']);

//Filmtono songs and singles
$router->get('/filmtono/album/songs/current', [AlbumsController::class, 'currentSong']);
$router->get('/filmtono/singles/current', [AlbumsController::class, 'currentSingle']);
$router->get('/filmtono/singles/delete', [AlbumsController::class, 'deleteSingle']);
$router->get('/filmtono/song/delete', [AlbumsController::class, 'deleteSong']);


//Filmtono Artists
$router->get('/filmtono/artists', [ArtistsController::class, 'index']);
$router->get('/api/filmtono/artists/artists', [ArtistsController::class, 'consultaArtistas']);
$router->get('/filmtono/artists/edit', [ArtistsController::class, 'edit']);
$router->post('/filmtono/artists/edit', [ArtistsController::class, 'edit']);
$router->get('/filmtono/artists/delete', [ArtistsController::class, 'delete']); 

//Filmtono Genres
$router->get('/filmtono/genres', [GenresController::class, 'index']);
$router->get('/api/filmtono/genres', [GenresController::class, 'consultarGeneros']);
$router->get('/filmtono/genres/new', [GenresController::class, 'new']);
$router->post('/filmtono/genres/new', [GenresController::class, 'new']);
$router->get('/filmtono/genres/edit', [GenresController::class, 'edit']);
$router->post('/filmtono/genres/edit', [GenresController::class, 'edit']);
$router->get('/filmtono/genres/delete', [GenresController::class, 'delete']);

//Filmtono Keywords
$router->get('/filmtono/categories/keywords', [KeywordsController::class, 'index']);
$router->get('/api/filmtono/keywords', [KeywordsController::class, 'consultarKeywords']);
$router->get('/filmtono/categories/keywords/new', [KeywordsController::class, 'new']);
$router->post('/filmtono/categories/keywords/new', [KeywordsController::class, 'new']);
$router->get('/filmtono/categories/keywords/edit', [KeywordsController::class, 'edit']);
$router->post('/filmtono/categories/keywords/edit', [KeywordsController::class, 'edit']);
$router->get('/filmtono/keywords/delete', [KeywordsController::class, 'delete']);

//Filmtono Languages
$router->get('/filmtono/languages', [LanguagesController::class, 'index']);
$router->get('/api/filmtono/languages', [LanguagesController::class, 'consultarIdiomas']);
$router->get('/filmtono/languages/new', [LanguagesController::class, 'new']);
$router->post('/filmtono/languages/new', [LanguagesController::class, 'new']);
$router->get('/filmtono/languages/edit', [LanguagesController::class, 'edit']);
$router->post('/filmtono/languages/edit', [LanguagesController::class, 'edit']);
$router->get('/filmtono/languages/delete', [LanguagesController::class, 'delete']);

//Filmtono Contracts
$router->get('/filmtono/contracts', [ContractsController::class, 'index']);
$router->get('/filmtono/contracts/current', [ContractsController::class, 'current']);
$router->get('/api/filmtono/contracts', [ContractsController::class, 'contratos']);
$router->get('/filmtono/contracts/delete', [ContractsController::class, 'delete']);

//Filmtono messages
$router->get('/filmtono/messages', [MessagesController::class, 'index']);
$router->get('/filmtono/messages/delete', [MessagesController::class, 'delete']);


//API Controllers
$router->post('/api/profile', [APIProfileController::class, 'profile']);
$router->post('/api/profile/status', [APIProfileController::class, 'profileStatus']);
$router->post('/api/profile/sellos', [APIProfileController::class, 'profileSellos']);

//debugging($router);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();



