import { gridSongs,songsInput, writers, writersInput, publisher, publisherInput, selloSelect2, phonogram, artistaSelect } from "./selectores.js";
import { readLang, readJSON, eliminarItem, normalizeText, caps } from "../base/funciones.js";

export async function consultaSongs(){
    //retrieve the URL of the current page with paarameters
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    const id = params.get('id');
    try{
        const resultado = await fetch(window.location.origin+'/api/music/albums/songs'+'?id='+id);
        const datos = await resultado.json();
        mostrarSongs(datos);
    }catch(error){
        console.log(error);
    }
}

async function mostrarSongs(datos){
    const lang = await readLang();
    const alerts = await readJSON();

    datos.forEach(song => {
        const {id, titulo, version, isrc, sello, artista_name, genero_en, genero_es, gensec_en, gensec_es, categorias_en, categorias_es, idioma_en, idioma_es, nivel_cancion_en, nivel_cancion_es} = song;

        const linkSingle = document.createElement('A');
        linkSingle.href = window.location.origin+'/music/album/songs/current?id='+id;
        linkSingle.classList.add('cards__card');

        const cardSingle = document.createElement('DIV');

        const cardInfo = document.createElement('DIV');
        cardInfo.classList.add('cards__info');

        const cardTitle = document.createElement('P');
        cardTitle.textContent = titulo;
        cardTitle.classList.add('cards__text', 'cards__text--span', 'text-green', 'text-24');

        const cardArtista = document.createElement('P');
        cardArtista.textContent = artista_name;
        cardArtista.classList.add('cards__text', 'text-24', 'text-yellow');

        const cardISRC = document.createElement('DIV');
        cardISRC.classList.add('cards__info--div');

        const cardISRCTitle = document.createElement('P');
        cardISRCTitle.textContent = 'ISRC: ';
        cardISRCTitle.classList.add('cards__text', 'cards__text--span');

        const cardISRCInfo = document.createElement('P');
        cardISRCInfo.textContent = isrc;
        cardISRCInfo.classList.add('cards__text');

        cardISRC.appendChild(cardISRCTitle);
        cardISRC.appendChild(cardISRCInfo);

        const cardVersion = document.createElement('DIV');
        cardVersion.classList.add('cards__info--div');

        const cardVersionTitle = document.createElement('P');
        cardVersionTitle.textContent = alerts['version'][lang]+': ';
        cardVersionTitle.classList.add('cards__text', 'cards__text--span');

        const cardVersionInfo = document.createElement('P');
        cardVersionInfo.textContent = version;
        cardVersionInfo.classList.add('cards__text');

        cardVersion.appendChild(cardVersionTitle);
        cardVersion.appendChild(cardVersionInfo);

        const cardGenre = document.createElement('DIV');
        cardGenre.classList.add('cards__info--div');

        const cardGenreTitle = document.createElement('P');
        cardGenreTitle.classList.add('cards__text', 'cards__text--span');
        const cardGenreInfo = document.createElement('P');
        cardGenreInfo.classList.add('cards__text');

        if(lang === 'en'){
            cardGenreTitle.textContent = alerts['genre'][lang]+': ';
            cardGenreInfo.textContent = genero_en;
        }else{
            cardGenreTitle.textContent = alerts['genre'][lang]+': ';
            cardGenreInfo.textContent = genero_es;
        }

        cardGenre.appendChild(cardGenreTitle);
        cardGenre.appendChild(cardGenreInfo);

        const cardGenreSec = document.createElement('DIV');
        cardGenreSec.classList.add('cards__info--div');

        const cardGenreSecTitle = document.createElement('P');
        cardGenreSecTitle.classList.add('cards__text', 'cards__text--span');
        const cardGenreSecInfo = document.createElement('P');
        cardGenreSecInfo.classList.add('cards__text');

        if(lang === 'en'){
            cardGenreSecTitle.textContent = alerts['genre-sec'][lang]+': ';
            cardGenreSecInfo.textContent = gensec_en;
        }else{
            cardGenreSecTitle.textContent = alerts['genre-sec'][lang]+': ';
            cardGenreSecInfo.textContent = gensec_es;
        }
        
        cardGenreSec.appendChild(cardGenreSecTitle);
        cardGenreSec.appendChild(cardGenreSecInfo);

        const cardCategories = document.createElement('DIV');
        cardCategories.classList.add('cards__info--div');

        const cardCategoriesTitle = document.createElement('P');
        cardCategoriesTitle.classList.add('cards__text', 'cards__text--span');
        const cardCategoriesInfo = document.createElement('P');
        cardCategoriesInfo.classList.add('cards__text');

        if(lang === 'en'){
            cardCategoriesTitle.textContent = alerts['categories'][lang]+': ';
            cardCategoriesInfo.textContent = categorias_en;
        }else{
            cardCategoriesTitle.textContent = alerts['categories'][lang]+': ';
            cardCategoriesInfo.textContent = categorias_es;
        }
        
        cardCategories.appendChild(cardCategoriesTitle);
        cardCategories.appendChild(cardCategoriesInfo);

        const cardIdiomas = document.createElement('DIV');
        cardIdiomas.classList.add('cards__info--div');

        const cardIdiomasTitle = document.createElement('P');
        cardIdiomasTitle.classList.add('cards__text', 'cards__text--span');
        const cardIdiomasInfo = document.createElement('P');
        cardIdiomasInfo.classList.add('cards__text');

        if(lang === 'en'){
            cardIdiomasTitle.textContent = alerts['languages'][lang]+': ';
            cardIdiomasInfo.textContent = idioma_en;
        }else{
            cardIdiomasTitle.textContent = alerts['languages'][lang]+': ';
            cardIdiomasInfo.textContent = idioma_es;
        }
        
        cardIdiomas.appendChild(cardIdiomasTitle);
        cardIdiomas.appendChild(cardIdiomasInfo);

        const cardLevel = document.createElement('DIV');
        cardLevel.classList.add('cards__info--div');

        const cardLevelTitle = document.createElement('P');
        cardLevelTitle.classList.add('cards__text', 'cards__text--span');
        const cardLevelInfo = document.createElement('P');
        cardLevelInfo.classList.add('cards__text');

        if(lang === 'en'){
            cardLevelTitle.textContent = alerts['level'][lang]+': ';
            cardLevelInfo.textContent = nivel_cancion_en;
        }else{
            cardLevelTitle.textContent = alerts['level'][lang]+': ';
            cardLevelInfo.textContent = nivel_cancion_es;
        }
        
        cardLevel.appendChild(cardLevelTitle);
        cardLevel.appendChild(cardLevelInfo);

        cardInfo.appendChild(cardTitle);
        cardInfo.appendChild(cardArtista);
        cardInfo.appendChild(cardISRC);
        cardInfo.appendChild(cardVersion);
        cardInfo.appendChild(cardGenre);
        cardInfo.appendChild(cardLevel);

        if(gensec_en !== null && gensec_es !== null){
            cardInfo.appendChild(cardGenreSec);
        }
        if(categorias_en !== null && categorias_es !== null){
            cardInfo.appendChild(cardCategories);
        }
        if(idioma_en !== null && idioma_es !== null){
            cardInfo.appendChild(cardIdiomas);
        }

        const cardActions = document.createElement('DIV');
        cardActions.classList.add('cards__actions');

        const btnEditar = document.createElement('A');
        btnEditar.classList.add('btn-update');
        btnEditar.href = window.location.origin+'/music/albums/song/edit?id='+id;

        const iconoLapiz = document.createElement('I');
        iconoLapiz.classList.add('fas', 'fa-pencil-alt', 'no-click');

        btnEditar.appendChild(iconoLapiz);

        const btnEliminar = document.createElement('BUTTON');
        btnEliminar.classList.add('btn-delete');
        btnEliminar.id = 'eliminar';
        btnEliminar.value = id;
        btnEliminar.dataset.item = 'song';
        btnEliminar.dataset.role = 'music';
        btnEliminar.onclick = eliminarItem;

        const iconEliminar = document.createElement('I');
        iconEliminar.classList.add('fa-solid', 'fa-trash-can', 'no-click');

        btnEliminar.appendChild(iconEliminar);

        cardActions.appendChild(btnEditar);
        cardActions.appendChild(btnEliminar);

        cardSingle.appendChild(cardInfo);
        cardSingle.appendChild(cardActions);

        linkSingle.appendChild(cardSingle);

        gridSongs.appendChild(linkSingle);
    });
    filtrarSongs();
}

function filtrarSongs(){
    songsInput.addEventListener('input', (e) => {
        const busqueda = normalizeText(e.target.value);
        const singles = gridSongs.querySelectorAll('.cards__card');

        singles.forEach(song => {
            const titulo = normalizeText(song.textContent);
            if(titulo.indexOf(busqueda) !== -1){
                song.style.display = 'flex';
                song.style.marginRight = '2rem';
                gridSongs.style.columnGap = '0';
            }else{
                song.style.display = 'none';
            }
        });
    });
}

export function songProperty(){
    writersInput.addEventListener('input', (e) => {
        const escritores = e.target.value;
        writers.textContent = escritores;
    });

    publisherInput.addEventListener('input', (e) => {
        const editorial = e.target.value;
        publisher.textContent = editorial;
    });


    let sello;
    let artista;
    if(selloSelect2){
        sello = selloSelect2.options[selloSelect2.selectedIndex].text;
    }
    if(artistaSelect){
        artista = artistaSelect.options[artistaSelect.selectedIndex].text;
    }

    if(selloSelect2 && artistaSelect){
         //Agregar sello y artista a la propiedad de la canción
        selloSelect2.addEventListener('change', (e) => {
            sello = selloSelect2.options[selloSelect2.selectedIndex].text;
            phonogram.textContent = sello+' - '+artista;

        });

        artistaSelect.addEventListener('change', (e) => {
            artista = artistaSelect.options[artistaSelect.selectedIndex].text;
            phonogram.textContent = sello+' - '+artista;
        });
    }
}