import { artistasInput, gridArtistas } from './selectores.js';
import { readLang, readJSON, normalizeText } from '../base/funciones.js';

export async function consultaArtistas(){
    try{
        const resultado = await fetch(window.location.origin+'/api/public/artists');
        const datos = await resultado.json();
        mostrarArtistas(datos);
    }catch(error){
        console.log(error);
    }
}
export async function mostrarArtistas(datos){
    datos.forEach(artist => {
        const {id, nombre, banner} = artist;

        //generar el link para la artist
        const artistLink = document.createElement('A');
        artistLink.classList.add('main__artists__card');
        artistLink.href = '/artist?id='+id;

        //Generar el contenedor de la información del usuario
        const card = document.createElement('DIV');
        card.classList.add('main__artists__item');

        let artistVideo;

        if(banner){
            artistVideo = document.createElement('IFRAME');
            artistVideo.classList.add('main__artists__video');
            artistVideo.src = 'https://www.youtube.com/embed/'+banner+'?controls=0&showinfo=0&rel=0&autoplay=1&mute=1&loop=1&playlist='+banner;
            artistVideo.frameborder = '0';
            artistVideo.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
            artistVideo.allowFullscreen = true;
            artistVideo.loading = 'lazy';
        }else{
            artistVideo = document.createElement('IMG');
            artistVideo.classList.add('main__artists__img');
            artistVideo.src = '/build/img/artist.webp';
            artistVideo.alt = nombre;
        }

        const artistName = document.createElement('P');
        artistName.classList.add('main__artists__nombre');
        artistName.textContent = nombre;

        //agregar la información al contenedor
        card.appendChild(artistVideo);
        card.appendChild(artistName);


        //agregar el link contenedor a la tarjeta
        artistLink.appendChild(card);
        //agregar el contenedor de la información al grid
        gridArtistas.appendChild(artistLink);
    });
        filtraArtistas();
}

function filtraArtistas(){
        artistasInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.main__artists__item');

                cards.forEach(card => {
                        const artista = normalizeText(card.textContent);
                        if(artista.indexOf(texto) !== -1){
                                card.style.display = 'block';
                                card.style.marginRight = '2rem';
                                gridArtistas.style.columnGap = '0';
                        }else{
                                card.style.display = 'none';
                        }
                });
        }); 
}