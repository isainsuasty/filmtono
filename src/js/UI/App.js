import { dropdownDiv, passbtn, wrapper, gridCategorias, gridGeneros, gridCategory, mensajeInput, player, gridArtistas, artistPlaylist, featuredPlaylist, gridCategorySongs, gridCanciones, categoryButtons, bodyPublic} from "./selectores.js";
import { chooseLang } from "./language.js";
import { UI, showPassword, mainSlider, mensaje } from "./UI.js";
import { btnSubmitLoader, loaderTimerExtra } from "../base/funciones.js";
import { submitBtns } from '../base/selectores.js';
import { consultaCategorias } from "./categories.js";
import { consultaGeneros } from "./generos.js";
import { consultaCategory } from "./category.js";
import { initializePlayer } from "./videos.js";
import { consultaArtistas } from "./artists.js";
import { consultaCancionesArtista } from "./artist-playlist.js";
import { consultaFeatured } from "./featured-playlist.js";
import { consultaCategorySongs } from "./categorySongs.js";
import { consultaCanciones, tagsFilters } from "./canciones-search.js";
import { setupCategoryButtons } from "./categorias-playlist.js";

class App{
    constructor(){
        this.initApp();
    }

    initApp(){
        if(bodyPublic){
            loaderTimerExtra();
        }
        if(dropdownDiv){
            UI();
        }
        if(chooseLang){
            chooseLang();
        }
        if(passbtn){
            showPassword();
        }
        if(submitBtns){
            btnSubmitLoader();
        }
        if(wrapper){
            mainSlider();
        }
        if(gridCategorias){
            consultaCategorias();
        }
        if(gridGeneros){
            consultaGeneros();
        }
        if(gridCategory){
            consultaCategory();
        }
        if(mensajeInput){
            mensaje();
        }
        if(featuredPlaylist){
            document.addEventListener('DOMContentLoaded', () => {
                consultaFeatured();
            });
        }
        if(gridArtistas){
            consultaArtistas();
        }
        if(artistPlaylist){
            consultaCancionesArtista();
        }
        if(gridCategorySongs){
            consultaCategorySongs();
        }
        if(gridCanciones){
            consultaCanciones();
            tagsFilters();
        }
        if(categoryButtons){
            document.addEventListener('DOMContentLoaded', () => {
                 setupCategoryButtons();
            });
        }
    }
}

export default App;