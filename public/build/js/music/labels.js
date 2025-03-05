import {gridSellos, sellosInput} from './selectores.js';
import {readLang, readJSON, eliminarItem, normalizeText} from '../base/funciones.js';

export async function consultaSellos(){
    try{
        const resultado = await fetch(window.location.origin+'/api/music/labels');
        const datos = await resultado.json();
       mostrarSellos(datos);
    }catch(error){
        console.log(error);
    }
}

async function mostrarSellos(datos){
    const lang = await readLang();
    const alerts = await readJSON();

    datos.forEach(sello => {
        //extract the type of contract from the name of the file nombre_doc
        const{id, nombre, creado} = sello;

        //Create the info section
        const cardSello = document.createElement('div');
        cardSello.classList.add('cards__card');

        const cardInfo = document.createElement('div');
        cardInfo.classList.add('cards__info');

        const titleSello = document.createElement('p');
        titleSello.textContent = nombre;
        titleSello.classList.add('cards__text', 'cards__text--span');

        const fechaSello = document.createElement('p');
        //add date as day/month/year
        const date = new Date(creado);
        const options = {year: 'numeric', month: 'short', day: 'numeric'};
        const fechaFormat = date.toLocaleDateString(lang, options);
        fechaSello.textContent = fechaFormat;
        fechaSello.classList.add('cards__text');

        //Create the actions section
        const cardActions = document.createElement('div');
        cardActions.classList.add('cards__actions');

        //generar el botón para editar el sello
        const btnEditar = document.createElement('A');
        btnEditar.classList.add('btn-update');
        btnEditar.href = '/music/labels/edit?id='+id;

        //generar ícono de lápiz para el botón de editar
        const iconoLapiz = document.createElement('I');
        iconoLapiz.classList.add('fa-solid', 'fa-pencil', 'no-click');

        //Agregar el ícono al botón
        btnEditar.appendChild(iconoLapiz);

        const btnEliminar = document.createElement('button');
        btnEliminar.classList.add('btn-delete');
        btnEliminar.id = 'eliminar';
        btnEliminar.value = id;
        btnEliminar.dataset.item = 'labels';
        btnEliminar.dataset.role = 'music';
        btnEliminar.onclick = eliminarItem;

        const iconEliminar = document.createElement('i');
        iconEliminar.classList.add('fa-solid', 'fa-trash-can', 'no-click');

        btnEliminar.appendChild(iconEliminar);
        cardActions.appendChild(btnEditar);
        cardActions.appendChild(btnEliminar);

        cardInfo.appendChild(titleSello);
        cardInfo.appendChild(fechaSello);

        cardSello.appendChild(cardInfo);
        cardSello.appendChild(cardActions);

  
        gridSellos.appendChild(cardSello);
    });
    filtrarSellos();
}

function filtrarSellos(){
    sellosInput.addEventListener('input', e => {
        const texto = normalizeText(e.target.value);
        const cards = document.querySelectorAll('.cards__card');

        cards.forEach(card => {
            const nombre = normalizeText(card.textContent);
            if(nombre.indexOf(texto) !== -1){
                card.style.display = 'flex';
                card.style.marginRight = '2rem';
                gridSellos.style.columnGap = '0';
            }else{
                card.style.display = 'none';
            }
        });
    }); 
}