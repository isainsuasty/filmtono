import {gridLabels, labelsInput} from './selectores.js';
import {readLang, readJSON, eliminarItem, normalizeText} from '../base/funciones.js';
export async function consultaLabels(){
    try{
        const resultado = await fetch(window.location.origin+'/api/filmtono/labels');
        const datos = await resultado.json();
       mostrarLabels(datos);
    }catch(error){
        console.log(error);
    }
}

async function mostrarLabels(datos){
    const lang = await readLang();
    const alerts = await readJSON();
    datos.forEach(userLabel => {
        //extract the type of contract from the name of the file nombre_doc
        const{labelId, labelName, labelDate, userId, userName, companyId, companyName, musicType} = userLabel;

        const cardLink = document.createElement('a');
        cardLink.classList.add('cards__link');
        cardLink.href = '/filmtono/labels/current?id='+labelId;

        //Create the info section
        const cardLabel = document.createElement('div');
        cardLabel.classList.add('cards__card');

        const cardInfo = document.createElement('div');
        cardInfo.classList.add('cards__info');


        const typeLabel = document.createElement('H3');
        typeLabel.classList.add('card__title');
        if(musicType === '1'){
            typeLabel.textContent = alerts['aggregator'][lang];
        } else if(musicType === '2'){
            typeLabel.textContent = alerts['publisher'][lang];
        } else {
            typeLabel.textContent = alerts['label'][lang];
        }

        const nameInfo = document.createElement('div');
        nameInfo.classList.add('cards__info--div');

        const labelTitle = document.createElement('p');
        labelTitle.textContent = alerts['label-name'][lang]+':';
        labelTitle.classList.add('cards__text', 'cards__text--span');

        const labelNameInfo = document.createElement('p');
        labelNameInfo.textContent = labelName;
        labelNameInfo.classList.add('cards__text');

        nameInfo.appendChild(labelTitle);
        nameInfo.appendChild(labelNameInfo);

        const dateInfo = document.createElement('div');
        dateInfo.classList.add('cards__info--div');

        const dateTitle = document.createElement('p');
        dateTitle.textContent = alerts['label-creation'][lang]+':';
        dateTitle.classList.add('cards__text', 'cards__text--span');

        const dateLabel = document.createElement('p');
        const date = new Date(labelDate);
        const options = {year: 'numeric', month: 'short', day: 'numeric'};
        const dateFormated = date.toLocaleDateString(lang, options);
        dateLabel.textContent = dateFormated;
        dateLabel.classList.add('cards__text');

        dateInfo.appendChild(dateTitle);
        dateInfo.appendChild(dateLabel);

        const companyInfo = document.createElement('div');
        companyInfo.classList.add('cards__info--div');

        const companyTitle = document.createElement('p');
        companyTitle.textContent = alerts['company'][lang]+':';
        companyTitle.classList.add('cards__text', 'cards__text--span');

        const companyNameInfo = document.createElement('p');
        companyNameInfo.textContent = companyName;
        companyNameInfo.classList.add('cards__text');

        companyInfo.appendChild(companyTitle);
        companyInfo.appendChild(companyNameInfo);

        const userInfo = document.createElement('div');
        userInfo.classList.add('cards__info--div');

        const userTitle = document.createElement('p');
        userTitle.textContent = alerts['user'][lang]+':';
        userTitle.classList.add('cards__text', 'cards__text--span');

        const userNameInfo = document.createElement('p');
        userNameInfo.textContent = userName;
        userNameInfo.classList.add('cards__text');

        userInfo.appendChild(userTitle);
        userInfo.appendChild(userNameInfo);

        //Create the actions section
        const cardActions = document.createElement('div');
        cardActions.classList.add('cards__actions');

        const btnEliminar = document.createElement('button');
        btnEliminar.classList.add('btn-delete');
        btnEliminar.id = 'eliminar';
        btnEliminar.value = labelId;
        btnEliminar.dataset.item = 'labels';
        btnEliminar.dataset.role = 'filmtono';
        btnEliminar.onclick = eliminarItem;

        const iconEliminar = document.createElement('i');
        iconEliminar.classList.add('fa-solid', 'fa-trash-can', 'no-click');

        btnEliminar.appendChild(iconEliminar);
        cardActions.appendChild(btnEliminar);

        cardInfo.appendChild(typeLabel);
        cardInfo.appendChild(nameInfo);
        cardInfo.appendChild(dateInfo);
        cardInfo.appendChild(companyInfo);
        cardInfo.appendChild(userInfo);

        cardLink.appendChild(cardInfo);
        cardLink.appendChild(cardActions);

        cardLabel.appendChild(cardLink);
        gridLabels.appendChild(cardLabel);
    });
    filtrarLabels();
}

function filtrarLabels(){
    labelsInput.addEventListener('input', e => {
        const texto = normalizeText(e.target.value);
        const cards = document.querySelectorAll('.cards__card');

        cards.forEach(card => {
            const nombre = normalizeText(card.textContent);
            if(nombre.indexOf(texto) !== -1){
                card.style.display = 'flex';
                card.style.marginRight = '2rem';
                gridLabels.style.columnGap = '0';
            }else{
                card.style.display = 'none';
            }
        });
    }); 
}