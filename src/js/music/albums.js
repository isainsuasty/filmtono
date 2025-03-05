import { gridAlbumes,albumesInput } from "./selectores.js";
import { readLang, readJSON, eliminarItem, normalizeText, caps } from "../base/funciones.js";

export async function consultaAlbumes(){
    try{
        const resultado = await fetch(window.location.origin+'/api/music/albums/albums');
        const datos = await resultado.json();
        mostrarAlbumes(datos);
    }catch(error){
        console.log(error);
    }
}

async function mostrarAlbumes(datos){
    const lang = await readLang();
    const alerts = await readJSON();

    datos.forEach(album => {
        const {id, titulo, portada, upc, publisher, artista_name} = album;

        const linkAlbum = document.createElement('A');
        linkAlbum.href = window.location.origin+'/music/albums/current?id='+id;
        linkAlbum.classList.add('cards__card');

        const cardAlbum = document.createElement('DIV');

        const cardInfo = document.createElement('DIV');
        cardInfo.classList.add('cards__info');

        const imgAlbum = document.createElement('IMG');
        imgAlbum.src = '/portadas/'+portada;
        imgAlbum.alt = titulo;
        imgAlbum.classList.add('cards__img', 'cards__img--album');

        const cardTitle = document.createElement('P');
        cardTitle.textContent = titulo;
        cardTitle.classList.add('cards__text', 'cards__text--span', 'text-green', 'text-24', 'mBottom-1');

        const cardArtista = document.createElement('P');
        cardArtista.textContent = artista_name;
        cardArtista.classList.add('cards__text', 'text-24', 'text-yellow', 'mBottom-1');

        const cardUPC = document.createElement('DIV');
        cardUPC.classList.add('cards__info--div');

        const cardUPCTitle = document.createElement('P');
        cardUPCTitle.textContent = 'UPC: ';
        cardUPCTitle.classList.add('cards__text', 'cards__text--span');

        const cardUPCInfo = document.createElement('P');
        cardUPCInfo.textContent = upc;
        cardUPCInfo.classList.add('cards__text');

        cardUPC.appendChild(cardUPCTitle);
        cardUPC.appendChild(cardUPCInfo);

        const cardPublisher = document.createElement('DIV');
        cardPublisher.classList.add('cards__info--div');

        const cardPublisherTitle = document.createElement('P');
        cardPublisherTitle.textContent = alerts['publisher'][lang]+': ';
        cardPublisherTitle.classList.add('cards__text', 'cards__text--span');

        const cardPublisherInfo = document.createElement('P');
        cardPublisherInfo.textContent = publisher;
        cardPublisherInfo.classList.add('cards__text');

        cardPublisher.appendChild(cardPublisherTitle);
        cardPublisher.appendChild(cardPublisherInfo);

        cardInfo.appendChild(imgAlbum);
        cardInfo.appendChild(cardTitle);
        cardInfo.appendChild(cardArtista);
        cardInfo.appendChild(cardUPC);
        cardInfo.appendChild(cardPublisher);

        const cardActions = document.createElement('DIV');
        cardActions.classList.add('cards__actions');

        const btnEditar = document.createElement('A');
        btnEditar.classList.add('btn-update');
        btnEditar.href = window.location.origin+'/music/albums/edit?id='+id;

        const iconoLapiz = document.createElement('I');
        iconoLapiz.classList.add('fas', 'fa-pencil-alt', 'no-click');

        btnEditar.appendChild(iconoLapiz);

        const btnEliminar = document.createElement('BUTTON');
        btnEliminar.classList.add('btn-delete');
        btnEliminar.id = 'eliminar';
        btnEliminar.value = id;
        btnEliminar.dataset.item = 'albums';
        btnEliminar.dataset.role = 'music';
        btnEliminar.onclick = eliminarItem;

        const iconEliminar = document.createElement('I');
        iconEliminar.classList.add('fa-solid', 'fa-trash-can', 'no-click');

        btnEliminar.appendChild(iconEliminar);

        cardActions.appendChild(btnEditar);
        cardActions.appendChild(btnEliminar);

        cardAlbum.appendChild(cardInfo);
        cardAlbum.appendChild(cardActions);

        linkAlbum.appendChild(cardAlbum);

        gridAlbumes.appendChild(linkAlbum);
    });
    filtrarAlbumes();
}

function filtrarAlbumes(){
    albumesInput.addEventListener('input', (e) => {
        const busqueda = normalizeText(e.target.value);
        const albumes = gridAlbumes.querySelectorAll('.cards__card');

        albumes.forEach(album => {
            const titulo = normalizeText(album.textContent);
            if(titulo.indexOf(busqueda) !== -1){
                album.style.display = 'flex';
                album.style.marginRight = '2rem';
                gridAlbumes.style.columnGap = '0';
            }else{
                album.style.display = 'none';
            }
        });
    });
}