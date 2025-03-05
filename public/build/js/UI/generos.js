import { generosInput, gridGeneros } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';

export async function consultaGeneros(){
    try{
        const resultado = await fetch(window.location.origin+'/api/public/genres');
        const datos = await resultado.json();
        mostrarGeneros(datos);
        console.log(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarGeneros(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        datos.forEach(genero => {
                const {id, genero_en, genero_es} = genero;

                //generar el link para la genero
                const generoLink = document.createElement('A');
                generoLink.classList.add('p-cards__grid__link');
                generoLink.href = '/category/genre?&id='+id;
                
                

                //generar la etiqueta para el tipo de usuario
                const generoTitle = document.createElement('P');
                generoTitle.classList.add('p-cards__grid__text');
                if(lang == 'es'){
                        generoTitle.textContent = genero_es;
                }else{
                        generoTitle.textContent = genero_en;
                }
                

                //Generar el contenedor de la información del usuario
                const card = document.createElement('DIV');
                card.classList.add('p-cards__grid__item', 'card-public');

                //agregar la información al contenedor
                generoLink.appendChild(generoTitle);
                //agregar el link contenedor a la tarjeta
                card.appendChild(generoLink);
                //agregar el contenedor de la información al grid
                gridGeneros.appendChild(card);
        });
        filtrageneros();
}

function filtrageneros(){
        generosInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card-public');

                cards.forEach(card => {
                        const generoTitle = normalizeText(card.textContent);
                        if(generoTitle.indexOf(texto) !== -1){
                                card.style.display = 'block';
                        }else{
                                card.style.display = 'none';
                        }
                });
        });
}