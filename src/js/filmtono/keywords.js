import { keywordsInput, gridKeywords } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';

export async function consultaKeywords(){
    try{
        //get the id from the url
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        const category = urlParams.get('category');
        const url = window.location.origin+'/api/filmtono/keywords?id='+id+'&category='+category;
        const resultado = await fetch(url);
        const datos = await resultado.json();
        mostrarKeywords(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarKeywords(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        //get the data and convert all to lowercase
        datos = datos.map(keyword => {
            return {
                id: keyword.id,
                keyword_en: keyword.keyword_en.toLowerCase(),
                keyword_es: keyword.keyword_es.toLowerCase()
            }
        });
        //order the keywords by alphabetical order depending on the language
        datos.sort((a, b) => {
            if(lang === 'es'){
                if(a.keyword_es < b.keyword_es){
                    return -1;
                }
                if(a.keyword_es > b.keyword_es){
                    return 1;
                }
                return 0;
            }else{
                if(a.keyword_en < b.keyword_en){
                    return -1;
                }
                if(a.keyword_en > b.keyword_en){
                    return 1;
                }
                return 0;
            }
        });

        datos.forEach(keyword => {
                const {id, keyword_en, keyword_es, id_categoria} = keyword;
                //generar el link para la keyword
                const keywordDiv = document.createElement('DIV');
                keywordDiv.classList.add('cards__div');

                //generar la etiqueta para el tipo de usuario
                const keywordTitle = document.createElement('H3');
                keywordTitle.classList.add('card__info--title');
                if(lang == 'es'){
                        keywordTitle.textContent = keyword_es;
                }else{
                        keywordTitle.textContent = keyword_en;
                }
                const urlParams = new URLSearchParams(window.location.search);
                const category = urlParams.get('category');
                const btnEditar = document.createElement('A');
                btnEditar.classList.add('btn-update');
                btnEditar.href = '/filmtono/categories/keywords/edit?id='+id+'&category='+category;
                

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
                btnEliminar.dataset.item = 'keywords';
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
                keywordDiv.appendChild(keywordTitle);
                keywordDiv.appendChild(contenedorBotones);
                //agregar el divkeywordDiv contenedor a la tarjeta
                card.appendChild(keywordDiv);
                //agregar el contenedor de la información al grid
                gridKeywords.appendChild(card);
        });
        filtrakeywords();
}

function filtrakeywords(){
        keywordsInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                        const keywordTitle = normalizeText(card.textContent);
                        if(keywordTitle.indexOf(texto) !== -1){
                                card.style.display = 'flex';
                                card.style.marginRight = '2rem';
                                gridKeywords.style.columnGap = '0';
                        }else{
                                card.style.display = 'none';
                        }
                });
        }); 
}