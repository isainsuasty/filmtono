import {gridArtistas, artistasInput, er} from './selectores.js';
import {readLang, readJSON, eliminarItem, normalizeText, caps} from '../base/funciones.js';

export async function consultaArtistas(){
    try{
        const resultado = await fetch(window.location.origin+'/api/music/artists/artists');
        const datos = await resultado.json();
       mostrarArtistas(datos);
    }catch(error){
        console.log(error);
    }
}

async function mostrarArtistas(datos){
    const lang = await readLang();
    const alerts = await readJSON();

    datos.forEach(artista => {
        //extract the type of contract from the name of the file nombre_doc
        const{id, nombre, precio_show, nivel_en, nivel_es, instagram, facebook, twitter, youtube, spotify, tiktok, website, banner} = artista;

        //Create the info section
        const cardArtista = document.createElement('div');
        cardArtista.classList.add('cards__card');

        const cardInfo = document.createElement('div');
        cardInfo.classList.add('cards__info');

        const titleArtista = document.createElement('p');
        titleArtista.textContent = nombre;
        titleArtista.classList.add('cards__text', 'cards__text--span', 'text-green', 'text-24');

        cardInfo.appendChild(titleArtista);

        const precioInfo = document.createElement('DIV');
        precioInfo.classList.add('cards__info--div');

        const titlePrecio = document.createElement('p');
        titlePrecio.textContent = alerts['show-price'][lang]+':';
        titlePrecio.classList.add('cards__text', 'cards__text--span');

        const precioArtista = document.createElement('p');
        precioArtista.textContent = '$'+precio_show.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
        precioArtista.classList.add('cards__text');

        precioInfo.appendChild(titlePrecio);
        precioInfo.appendChild(precioArtista);

        const nivelInfo = document.createElement('DIV');
        nivelInfo.classList.add('cards__info--div');

        const titleNivel = document.createElement('p');
        titleNivel.textContent = lang === 'en' ? 'Level: ' : 'Nivel: ';
        titleNivel.classList.add('cards__text', 'cards__text--span');


        const nivelArtista = document.createElement('p');
        nivelArtista.textContent = lang === 'en' ? caps(nivel_en) : caps(nivel_es);
        nivelArtista.classList.add('cards__text');

        nivelInfo.appendChild(titleNivel);
        nivelInfo.appendChild(nivelArtista);

        const instagramInfo = document.createElement('DIV');
        instagramInfo.classList.add('cards__info--div');

        const titleInstagram = document.createElement('p');
        titleInstagram.textContent = 'Instagram:';
        titleInstagram.classList.add('cards__text', 'cards__text--span');

        const instagramArtista = document.createElement('p');
        instagramArtista.textContent = instagram;
        instagramArtista.classList.add('cards__text');

        instagramInfo.appendChild(titleInstagram);
        instagramInfo.appendChild(instagramArtista);

        const facebookInfo = document.createElement('DIV');
        facebookInfo.classList.add('cards__info--div');

        const titleFacebook = document.createElement('p');
        titleFacebook.textContent = 'Facebook:';
        titleFacebook.classList.add('cards__text', 'cards__text--span');

        const facebookArtista = document.createElement('p');
        facebookArtista.textContent = facebook;
        facebookArtista.classList.add('cards__text');

        facebookInfo.appendChild(titleFacebook);
        facebookInfo.appendChild(facebookArtista);

        const twitterInfo = document.createElement('DIV');
        twitterInfo.classList.add('cards__info--div');

        const titleTwitter = document.createElement('p');
        titleTwitter.textContent = 'Twitter:';
        titleTwitter.classList.add('cards__text', 'cards__text--span');

        const twitterArtista = document.createElement('p');
        twitterArtista.textContent = twitter;
        twitterArtista.classList.add('cards__text');

        twitterInfo.appendChild(titleTwitter);
        twitterInfo.appendChild(twitterArtista);

        const youtubeInfo = document.createElement('DIV');
        youtubeInfo.classList.add('cards__info--div');

        const titleYoutube = document.createElement('p');
        titleYoutube.textContent = 'Youtube:';
        titleYoutube.classList.add('cards__text', 'cards__text--span');

        const youtubeArtista = document.createElement('p');
        youtubeArtista.textContent = youtube;
        youtubeArtista.classList.add('cards__text');

        youtubeInfo.appendChild(titleYoutube);
        youtubeInfo.appendChild(youtubeArtista);

        const spotifyInfo = document.createElement('DIV');
        spotifyInfo.classList.add('cards__info--div');

        const titleSpotify = document.createElement('p');
        titleSpotify.textContent = 'Spotify:';
        titleSpotify.classList.add('cards__text', 'cards__text--span');

        const spotifyArtista = document.createElement('p');
        spotifyArtista.textContent = spotify;
        spotifyArtista.classList.add('cards__text');

        spotifyInfo.appendChild(titleSpotify);
        spotifyInfo.appendChild(spotifyArtista);

        const tiktokInfo = document.createElement('DIV');
        tiktokInfo.classList.add('cards__info--div');

        const titleTiktok = document.createElement('p');
        titleTiktok.textContent = 'Tiktok:';
        titleTiktok.classList.add('cards__text', 'cards__text--span');

        const tiktokArtista = document.createElement('p');
        tiktokArtista.textContent = tiktok;
        tiktokArtista.classList.add('cards__text');

        tiktokInfo.appendChild(titleTiktok);
        tiktokInfo.appendChild(tiktokArtista);

        const websiteInfo = document.createElement('DIV');
        websiteInfo.classList.add('cards__info--div');

        const titleWebsite = document.createElement('p');
        titleWebsite.textContent = 'Website:';
        titleWebsite.classList.add('cards__text', 'cards__text--span');

        const websiteArtista = document.createElement('p');
        websiteArtista.textContent = website;
        websiteArtista.classList.add('cards__text');

        websiteInfo.appendChild(titleWebsite);
        websiteInfo.appendChild(websiteArtista);

        const bannerInfo = document.createElement('DIV');
        bannerInfo.classList.add('cards__info--div');

        const titleBanner = document.createElement('p');
        titleBanner.textContent = alerts['banner-code'][lang]+':';
        titleBanner.classList.add('cards__text', 'cards__text--span');

        const bannerArtista = document.createElement('p');
        bannerArtista.textContent = banner;
        bannerArtista.classList.add('cards__text');

        bannerInfo.appendChild(titleBanner);
        bannerInfo.appendChild(bannerArtista);

        //Create the actions section
        const cardActions = document.createElement('div');
        cardActions.classList.add('cards__actions');

        //generar el botón para editar el sello
        const btnEditar = document.createElement('a');
        btnEditar.classList.add('btn-update');
        btnEditar.href = '/music/artists/edit?id='+id;

        //generar ícono de lápiz para el botón de editar
        const iconoLapiz = document.createElement('I');
        iconoLapiz.classList.add('fa-solid', 'fa-pencil', 'no-click');

        //Agregar el ícono al botón
        btnEditar.appendChild(iconoLapiz);

        const btnEliminar = document.createElement('button');
        btnEliminar.classList.add('btn-delete');
        btnEliminar.id = 'eliminar';
        btnEliminar.value = id;
        btnEliminar.dataset.item = 'artists';
        btnEliminar.dataset.role = 'music';
        btnEliminar.onclick = eliminarItem;

        const iconEliminar = document.createElement('i');
        iconEliminar.classList.add('fa-solid', 'fa-trash-can', 'no-click');

        btnEliminar.appendChild(iconEliminar);
        cardActions.appendChild(btnEditar);
        cardActions.appendChild(btnEliminar);

        cardArtista.appendChild(cardInfo);
        cardArtista.appendChild(precioInfo);
        cardArtista.appendChild(nivelInfo);
        cardArtista.appendChild(instagramInfo);
        cardArtista.appendChild(facebookInfo);
        cardArtista.appendChild(twitterInfo);
        cardArtista.appendChild(youtubeInfo);
        cardArtista.appendChild(spotifyInfo);
        cardArtista.appendChild(tiktokInfo);
        cardArtista.appendChild(websiteInfo);
        cardArtista.appendChild(bannerInfo);

        cardArtista.appendChild(cardActions);
  
        gridArtistas.appendChild(cardArtista);
    });
    filtrarArtistas();
}

function filtrarArtistas(){
    artistasInput.addEventListener('input', e => {
        const texto = normalizeText(e.target.value);
        const cards = document.querySelectorAll('.cards__card');

        cards.forEach(card => {
            const nombre = normalizeText(card.textContent);
            if(nombre.indexOf(texto) !== -1){
                card.style.display = 'flex';
                card.style.marginRight = '2rem';
                gridArtistas.style.columnGap = '0';
            }else{
                card.style.display = 'none';
            }
        });
    }); 
}