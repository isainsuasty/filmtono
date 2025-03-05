import { categoryInput, gridCategory } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';


export async function consultaCategory(){
    try{
        //get the id from the url
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        const category = urlParams.get('name');
        let url = '';
        if(!id){
            url = window.location.origin+'/api/public/category?name='+category;
        } else{
            url = window.location.origin+'/api/public/category?id='+id+'&name='+category;
        }
        const resultado = await fetch(url);
        const datos = await resultado.json();
        mostrarCategory(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarCategory(datos){
        const lang = await readLang();
        const alerts = await readJSON();

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
                const {id, keyword_en, keyword_es} = keyword;

                const url = new URL(window.location.href);
                const params = new URLSearchParams(url.search);
                const name = params.get('name');
                const cid = params.get('id');

                //generar el link para la keyword
                const keywordLink = document.createElement('A');
                keywordLink.classList.add('p-cards__grid__link');
                keywordLink.href = '/category/songs?cid='+cid+'&name='+name+'&id='+id;
                

                //generar la etiqueta para el tipo de usuario
                const keywordTitle = document.createElement('P');
                keywordTitle.classList.add('p-cards__grid__text');
                if(lang == 'es'){
                        keywordTitle.textContent = keyword_es;
                }else{
                        keywordTitle.textContent = keyword_en;
                }
                

                //Generar el contenedor de la información del usuario
                const card = document.createElement('DIV');
                card.classList.add('p-cards__grid__item', 'card-public');

                //agregar la información al contenedor
                keywordLink.appendChild(keywordTitle);
                //agregar el link contenedor a la tarjeta
                card.appendChild(keywordLink);
                //agregar el contenedor de la información al grid
                gridCategory.appendChild(card);
        });
        filtraCategory();
}

function filtraCategory(){
        categoryInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card-public');

                cards.forEach(card => {
                        const keywordTitle = normalizeText(card.textContent);
                        if(keywordTitle.indexOf(texto) !== -1){
                                card.style.display = 'block';
                        }else{
                                card.style.display = 'none';
                        }
                });
        });
}