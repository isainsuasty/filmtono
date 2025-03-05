import { idiomasInput, gridIdiomas } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';

export async function consultaIdiomas(){
    try{
        const url = window.location.origin+'/api/filmtono/languages';
        const resultado = await fetch(url);
        const datos = await resultado.json();
        mostrarIdiomas(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarIdiomas(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        //get the data and convert all to lowercase
        datos = datos.map(idioma => {
            return {
                id: idioma.id,
                idioma_en: idioma.idioma_en.toLowerCase(),
                idioma_es: idioma.idioma_es.toLowerCase()
            }
        });
        //order the idiomas by alphabetical order depending on the language
        datos.sort((a, b) => {
            if(lang === 'es'){
                if(a.idioma_es < b.idioma_es){
                    return -1;
                }
                if(a.idioma_es > b.idioma_es){
                    return 1;
                }
                return 0;
            }else{
                if(a.idioma_en < b.idioma_en){
                    return -1;
                }
                if(a.idioma_en > b.idioma_en){
                    return 1;
                }
                return 0;
            }
        });

        datos.forEach(idioma => {
                const {id, idioma_en, idioma_es, id_categoria} = idioma;
                //generar el link para la idioma
                const idiomaDiv = document.createElement('DIV');
                idiomaDiv.classList.add('cards__div');

                //generar la etiqueta para el tipo de usuario
                const idiomaTitle = document.createElement('H3');
                idiomaTitle.classList.add('card__info--title');
                if(lang == 'es'){
                        idiomaTitle.textContent = idioma_es;
                }else{
                        idiomaTitle.textContent = idioma_en;
                }
                const urlParams = new URLSearchParams(window.location.search);
                const category = urlParams.get('category');
                const btnEditar = document.createElement('A');
                btnEditar.classList.add('btn-update');
                btnEditar.href = '/filmtono/languages/edit?id='+id;
                

                //generar ícono de lápiz para el botón de editar
                const iconoLapiz = document.createElement('I');
                iconoLapiz.classList.add('fa-solid', 'fa-pencil', 'no-click');

                //Agregar el ícono al botón
                btnEditar.appendChild(iconoLapiz);

                //generar el botón para eliminar el usuario
                const btnEliminar = document.createElement('BUTTON');
                btnEliminar.classList.add('btn-delete');
                btnEliminar.value = id;
                btnEliminar.dataset.type = category;
                btnEliminar.dataset.role = 'filmtono';
                btnEliminar.dataset.item = 'languages';
                btnEliminar.onclick = eliminarItem;
                
                //generar ícono de basura para el botón de eliminar
                const iconoBasura = document.createElement('I');
                iconoBasura.classList.add('fa-solid', 'fa-trash-can', 'no-click');

                //Agregar el ícono al botón
                btnEliminar.appendChild(iconoBasura);
                btnEliminar.onclick = eliminarItem;

                //generar el contenedor de los botones
                const contenedorBotones = document.createElement('DIV');
                contenedorBotones.classList.add('card__acciones');

                //agregar los botones al contenedor
                contenedorBotones.appendChild(btnEditar);
                contenedorBotones.appendChild(btnEliminar);

                //Generar el contenedor de la información del usuario
                const card = document.createElement('DIV');
                card.classList.add('card');

                //agregar la información al contenedor
                idiomaDiv.appendChild(idiomaTitle);
                idiomaDiv.appendChild(contenedorBotones);
                //agregar el dividiomaDiv contenedor a la tarjeta
                card.appendChild(idiomaDiv);
                //agregar el contenedor de la información al grid
                gridIdiomas.appendChild(card);
        });
        filtraIdiomas();
}

function filtraIdiomas(){
        idiomasInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                        const idiomaTitle = normalizeText(card.textContent);
                        if(idiomaTitle.indexOf(texto) !== -1){
                                card.style.display = 'flex';
                                card.style.marginRight = '2rem';
                                gridIdiomas.style.columnGap = '0';
                        }else{
                                card.style.display = 'none';
                        }
                });
        }); 
}