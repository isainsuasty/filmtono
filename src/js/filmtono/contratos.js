import {contratosContainer, contratosSearch} from './selectores.js';
import {readLang, readJSON, eliminarItem, normalizeText} from '../base/funciones.js';

export async function consultaContratos(){
    try{
        const resultado = await fetch(window.location.origin+'/api/filmtono/contracts');
        const datos = await resultado.json();
       mostrarContratos(datos);
    }catch(error){
        console.log(error);
    }
}

async function mostrarContratos(datos){
    const lang = await readLang();
    const alerts = await readJSON();

    datos.forEach(contrato => {
        //extract the type of contract from the name of the file nombre_doc
        const tipoContrato = contrato.nombre_doc.split('-')[2];
        const{id, nombre, apellido, empresa, fecha} = contrato;

        //Create the card to wrap the contract info and actions
        const cardLink = document.createElement('a');
        cardLink.classList.add('cards__link');
        cardLink.href = '/filmtono/contracts/current?id='+id+'&type='+tipoContrato;

        //Create the info section
        const cardContrato = document.createElement('div');
        cardContrato.classList.add('cards__card');

        const cardInfo = document.createElement('div');
        cardInfo.classList.add('cards__info');

        const nameInfo = document.createElement('div');
        nameInfo.classList.add('cards__info--div');

        const titleNombre = document.createElement('p');
        titleNombre.textContent = alerts['contracts_user-name'][lang]+':';
        titleNombre.classList.add('cards__text', 'cards__text--span');

        const nombreCompleto = document.createElement('p');
        nombreCompleto.textContent = `${nombre} ${apellido}`;
        nombreCompleto.classList.add('cards__text');
        
        nameInfo.appendChild(titleNombre);
        nameInfo.appendChild(nombreCompleto);

        const empresaInfo = document.createElement('div');
        empresaInfo.classList.add('cards__info--div');

        const titleEmpresa = document.createElement('p');
        titleEmpresa.textContent = alerts['contracts_empresa'][lang]+':';
        titleEmpresa.classList.add('cards__text', 'cards__text--span');

        const empresaContrato = document.createElement('p');
        empresaContrato.textContent = empresa;
        empresaContrato.classList.add('cards__text');

        empresaInfo.appendChild(titleEmpresa);
        empresaInfo.appendChild(empresaContrato);

        const tipoInfo = document.createElement('div');
        tipoInfo.classList.add('cards__info--div');

        const titleTipo = document.createElement('p');
        titleTipo.textContent = alerts['contracts_type'][lang]+':';
        titleTipo.classList.add('cards__text', 'cards__text--span');

        const tipo = document.createElement('p');
        if(tipoContrato === 'music'){
            tipo.textContent = alerts['contracts_type-music'][lang];
        }else{
            tipo.textContent = alerts['contracts_type-artistic'][lang];
        }
        tipo.classList.add('cards__text');

        tipoInfo.appendChild(titleTipo);
        tipoInfo.appendChild(tipo);

        const fechaInfo = document.createElement('div');
        fechaInfo.classList.add('cards__info--div');

        const titleFecha = document.createElement('p');
        titleFecha.textContent = alerts['contracts_fecha'][lang]+':';
        titleFecha.classList.add('cards__text', 'cards__text--span');

        const fechaContrato = document.createElement('p');
        //add date as day/month/year
        const date = new Date(fecha);
        const options = {year: 'numeric', month: 'short', day: 'numeric'};
        const fechaFormat = date.toLocaleDateString(lang, options);
        fechaContrato.textContent = fechaFormat;
        fechaContrato.classList.add('cards__text');

        fechaInfo.appendChild(titleFecha);
        fechaInfo.appendChild(fechaContrato);

        //Create the actions section
        const cardActions = document.createElement('div');
        cardActions.classList.add('cards__actions');

        const btnEliminar = document.createElement('button');
        btnEliminar.classList.add('btn-delete');
        btnEliminar.id = 'eliminar';
        btnEliminar.value = id;
        btnEliminar.dataset.type = tipoContrato;
        btnEliminar.dataset.item = 'contracts';
        btnEliminar.dataset.role = 'filmtono';
        btnEliminar.onclick = eliminarItem;

        const iconEliminar = document.createElement('i');
        iconEliminar.classList.add('fa-solid', 'fa-trash-can', 'no-click');

        btnEliminar.appendChild(iconEliminar);
        cardActions.appendChild(btnEliminar);


        cardInfo.appendChild(nameInfo);
        cardInfo.appendChild(empresaInfo);
        cardInfo.appendChild(tipoInfo);
        cardInfo.appendChild(fechaInfo);

        cardLink.appendChild(cardInfo);
        cardLink.appendChild(cardActions);

        cardContrato.appendChild(cardLink);
        contratosContainer.appendChild(cardContrato);
    });
    filtrarContratos();
}

function filtrarContratos(){
    contratosSearch.addEventListener('input', e => {
        const texto = normalizeText(e.target.value);
        const cards = document.querySelectorAll('.cards__card');

        cards.forEach(card => {
            const nombre = normalizeText(card.textContent);
            if(nombre.indexOf(texto) !== -1){
                card.style.display = 'flex';
                card.style.marginRight = '2rem';
                contratosContainer.style.columnGap = '0';
            }else{
                card.style.display = 'none';
            }
        });
    }); 
}