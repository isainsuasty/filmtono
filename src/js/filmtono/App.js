import { artistaSecundario, artistasInput, btnAgregar, contratosContainer, gridUsuarios, portada, promoInput, gridCategorias, gridGeneros, gridKeywords, gridLabels, gridIdiomas, gridMensajes, gridArtistas, albumsBlock, gridAlbumes, gridSongs, gridSingles } from "./selectores.js";
import { chooseLang } from "../UI/language.js";
import { styleDatalist, styleFileInput, artistasSecundarios, addArtist } from "./artistas.js";
import { readFileName } from "./ux.js";
import { consultaContratos } from "./contratos.js";
import { consultaUsuarios } from "./users.js";
import { consultaCategorias } from "./categorias.js";
import { consultaGeneros } from "./generos.js";
import { consultaKeywords } from "./keywords.js";
import { consultaLabels } from "./labels.js";
import { consultaIdiomas } from "./idiomas.js";
import { consultaMensajes } from "./mensajes.js";
import { consultaArtistas } from "./artists.js";
import { consultaAlbumes } from "./albums.js";
import { consultaSongs } from "./songs.js";
import { consultaSingles } from "./singles.js";
import { changeTabs, eliminarItem, btnSubmitLoader, handleLanguageSelection
    , initializeLabelCheckbox, initializeFileNameDisplay } from "../base/funciones.js";
import {btnEliminar, submitBtns, tabsDiv, languageSelect, selloInput, fileInput} from '../base/selectores.js';
import { countryValue } from "../music/APIPaises.js";
import { btnSubmit, paisValue, formArtist } from "../music/selectores.js";
import { passbtn } from "../UI/selectores.js";
import { showPassword } from "../UI/UI.js";
import { validateArtistForm } from "../music/artistValidation.js";
import { musicTabs } from "../music/musicTabs.js";

class App{
    constructor(){
        this.initApp();
    }

    initApp(){
        if(chooseLang){
            chooseLang();
        }
        if(portada){
            styleFileInput();
        }
        if(artistaSecundario){
            artistasSecundarios();
        }
        if(btnAgregar){
            addArtist();
        }
        if(promoInput){
            readFileName();
        }
        if(contratosContainer){
            consultaContratos();
        }
        if(gridUsuarios){
            consultaUsuarios();
        }
        if(btnEliminar){
            btnEliminar.forEach(btn => {
                    btn.addEventListener('click', eliminarItem);
                }
            );
        }
        if(paisValue){
            countryValue();
        }
        if(tabsDiv){
            changeTabs();
        }
        if(passbtn){
            showPassword();
        }
        if(submitBtns){
            btnSubmitLoader();
        }
        if(gridCategorias){
            consultaCategorias();
        }
        if(gridGeneros){
            consultaGeneros();
        }
        if(gridKeywords){
            consultaKeywords();
        }
        if(gridLabels){
            consultaLabels();
        }
        if(gridIdiomas){
            consultaIdiomas();
        }
        if(gridMensajes){
            consultaMensajes();
        }
        if(gridArtistas){
            consultaArtistas();
        }
        if(formArtist){
            validateArtistForm();
        }
        if(languageSelect){
            handleLanguageSelection();
        }if(selloInput){
            initializeLabelCheckbox();
        }
        if(fileInput){
            initializeFileNameDisplay();
        }
        if(albumsBlock){
            musicTabs();
        }
        if(gridAlbumes){
            consultaAlbumes();
        }
        if(gridSongs){
            consultaSongs();
        }
        if(gridSingles){
            consultaSingles();
        }
    }
}

export default App;