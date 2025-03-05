import { gridCategorySongs, categorySongsInput } from "./selectores.js";

export async function consultaCategorySongs(){
    try{
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const currentUrl = window.location.pathname;
        const cid = params.get('cid');
        if(currentUrl === '/category/genre'){
            const id = params.get('id');
            const resultado = await fetch(window.location.origin+'/api/public/category/genre?id='+id);
            const datos = await resultado.json();
            mostrarCanciones(datos);
        } else{
            const id = params.get('id');
            const resultado = await fetch(window.location.origin+'/api/public/category/songs?cid='+cid+'&id='+id);
            const datos = await resultado.json();
            mostrarCanciones(datos);
        }

    }catch(error){
        console.log(error);
    }
}

async function mostrarCanciones(datos){
    datos.forEach(cancion => {
        const {titulo , url} = cancion;

        const card = document.createElement('DIV');
        card.classList.add('main__artists__item');

        const video = document.createElement('IFRAME');
        video.classList.add('main__artists__video');
        video.src = 'https://www.youtube.com/embed/'+url+'?controls=0&showinfo=0&rel=0&autoplay=1&mute=1&loop=1&playlist='+url;
        video.frameborder = '0';
        video.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        video.allowFullscreen = true;
        video.loading = 'lazy';

        const title = document.createElement('P');
        title.classList.add('main__artists__nombre');
        title.textContent = titulo;

        card.appendChild(video);
        card.appendChild(title);

        gridCategorySongs.appendChild(card);
    });
    filtraCanciones();
}

function filtraCanciones(){
    categorySongsInput.addEventListener('input', e => {
        const texto = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.main__artists__item');

        cards.forEach(card => {
            const title = card.querySelector('.main__artists__nombre').textContent.toLowerCase();
            if(title.indexOf(texto) !== -1){
                card.style.display = 'flex';
                card.style.marginRight = '2rem';
            }else{
                card.style.display = 'none';
            }
        });
    });
}