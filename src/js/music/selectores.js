//import {Empresa} from './Empresa.js';
export const er = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

export const num = /^[0-9]+$/;

//export const empresa = new Empresa();

//Selectores del registro de empresa
export const paisContacto = document.querySelector('#pais_contacto');
export const indicativo = document.querySelector('.tel-index');
export const selectPais = document.querySelector('#pais');
export const botones = document.querySelectorAll('.tab__button');
export const pagAnterior = document.querySelector('#anterior');
export const pagSiguiente = document.querySelector('#siguiente');
export const btnSubmit = document.querySelector('#btn-submit');
export const afterNav = document.querySelector('.tabs__nav__line');
export const btnContrato = document.querySelectorAll('.btn-contrato');
export const contratoMusical = document.querySelector('#contrato-musical');
export const contratoArtistico = document.querySelector('#contrato-artistico');
export const confirmContrato = document.querySelector('#confirm-contrato');
export const confirmContratoArt = document.querySelector('#confirm-contrato-art');
export const nombre = document.querySelector('#nombre');
export const cargo = document.querySelector('#cargo');
export const telContacto = document.querySelector('#tel_contacto');
export const telIndex = document.querySelector('#tel-index');
export const empresa = document.querySelector('#empresa');
export const idFiscal = document.querySelector('#id_fiscal');
export const direccion = document.querySelector('#direccion');
export const email = document.querySelector('#email');
export const tabsActions = document.querySelector('.tabs__pags');

export const terms = document.querySelector('#terms');
export const privacy = document.querySelector('#privacy');

export const divCheck = document.querySelector('#div-check');
export const hiddenMusic = document.querySelector('#signatureInput');
export const hiddenArtistic = document.querySelector('#signatureOptional');
export const countrySelected = document.querySelector('#current-pais');
export const paisValue = document.querySelectorAll('.pais-value');

//Albums and single tabs admin block
export const albumsBlock = document.querySelector('.tabs__music--albums');
export const singlesBlock = document.querySelector('.tabs__music--singles');
export const albumsBtn = document.querySelector('#btn-albums');
export const singlesBtn = document.querySelector('#btn-singles');
export const musicBtn = document.querySelectorAll('.tabs__music__buttons--btn');

//Selectores contrato dashboard
export const btnContratoDash = document.querySelectorAll('.btn-contrato');
export const firmasDashboard = document.querySelector('#firmar-contratos-dashboard');
export const dashboardEnlaces = document.querySelectorAll('.dashboard__enlace');

//selectores de la sección de sellos
export const gridSellos = document.querySelector('#grid-sellos');
export const sellosInput = document.querySelector('#sellos-search');

//Selectores de la sección de artistas
export const gridArtistas = document.querySelector('#grid-artistas');
export const artistasInput = document.querySelector('#artistas-search');

//Selectores de la validación de artistas
export const formArtist = document.querySelector('.form-artist');
export const url = document.querySelectorAll('.url');
export const artistFields = document.querySelectorAll('.form__group');

//Selectores de la sección de álbumes
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
export const writers = document.querySelector('#writers-property');
export const writersInput = document.querySelector('#escritores-song');
export const publisher = document.querySelector('#publisher-property');
export const publisherInput = document.querySelector('#publisher-song');
export const phonogram = document.querySelector('#phonogram-property');
export const selloSelect2 = document.querySelector('#sello-song');
export const artistaSelect = document.querySelector('#artista-song');