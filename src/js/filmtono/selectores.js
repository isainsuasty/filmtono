//Selectores de la sección de usuarios
export const container = document.querySelector('.dashboard__contenido');
export const gridUsuarios = document.querySelector('#grid-usuarios');

//Selectores de agregar artista
export const artistasInput = document.querySelectorAll('.artistas_input');
export const portada = document.querySelectorAll('.form__custom__input');

export const artistaSecundario = document.querySelector('#artsecundarios_input');
export const btnAgregar = document.querySelector('#btn-add-artist'); 

//Selectores de archivos
export const promoInput = document.getElementById('promos');
export const promoLabel = document.getElementById('promoLabel');

//Selectores de contratos
export const contratos ={
    id: null,
    nombre: '',
    apellido: '',
    empresa: '',
    fecha: '',
    nombre_doc: ''
};

export const contratosContainer = document.querySelector('#contracts-container');
export const contratosSearch = document.querySelector('#contratos-search');

//Selectores de la sección de categorías
export const gridCategorias = document.querySelector('#grid-categorias');
export const categoriasInput = document.querySelector('#categorias-search');

//selectores de la sección de géneros
export const gridGeneros = document.querySelector('#grid-generos');
export const generosInput = document.querySelector('#generos-search');

//selectores de la sección de keywords
export const gridKeywords = document.querySelector('#grid-keywords');
export const keywordsInput = document.querySelector('#keywords-search');

//selectores se la sección de sellos
export const gridLabels = document.querySelector('#grid-userLabel');
export const labelsInput = document.querySelector('#userLabel-search');

//Selectores de la sección de idiomas
export const gridIdiomas = document.querySelector('#grid-idiomas');
export const idiomasInput = document.querySelector('#idiomas-search');

//Selectores de la sección de mensajes
export const gridMensajes = document.querySelector('#grid-mensajes');
export const mensajesInput = document.querySelector('#mensajes-search');

//selectores de artistas
export const gridArtistas = document.querySelector('#grid-artistas');
export const artistasSearchInput = document.querySelector('#artistas-search');

//Albums and single tabs admin block
export const albumsBlock = document.querySelector('.tabs__music--albums');
export const singlesBlock = document.querySelector('.tabs__music--singles');
export const albumsBtn = document.querySelector('#btn-albums');
export const singlesBtn = document.querySelector('#btn-singles');
export const musicBtn = document.querySelectorAll('.tabs__music__buttons--btn');

//selectores de la sección de albums
export const gridAlbumes = document.querySelector('#grid-albumes');
export const albumesInput = document.querySelector('#albumes-search');

//Selectores de la sección de singles
export const gridSingles = document.querySelector('#grid-singles');
export const singlesInput = document.querySelector('#singles-search');
export const selloSelect = document.querySelector('#sello');
export const noLabelCheckbox = document.querySelector('#noLabel');
export const noLabelText = document.querySelector('#noLabelText');

//Selectores de la sección de songs
export const gridSongs = document.querySelector('#grid-songs');
export const songsInput = document.querySelector('#songs-search');