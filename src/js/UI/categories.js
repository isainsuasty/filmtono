import { categoriasInput, gridCategorias } from './selectores.js';
import { readLang, readJSON, normalizeText } from '../base/funciones.js';

export async function consultaCategorias(){
    try{
        const resultado = await fetch(window.location.origin+'/api/public/categories');
        const datos = await resultado.json();
        mostrarCategorias(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarCategorias(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        datos.forEach(categoria => {
                const {id, categoria_en, categoria_es} = categoria;

                //generar el link para la categoria
                const categoriaLink = document.createElement('A');
                categoriaLink.classList.add('p-cards__grid__link');
                if(categoria.id === '1'){
                    categoriaLink.href = '/category/genres?id='+id+'&name='+categoria_en;
                } else{
                    categoriaLink.href = '/category?id='+id+'&name='+categoria_en;
                }

                //generar la etiqueta para el tipo de usuario
                const categoriaTitle = document.createElement('P');
                categoriaTitle.classList.add('p-cards__grid__text');
                if(lang == 'es'){
                        categoriaTitle.textContent = categoria_es;
                }else{
                        categoriaTitle.textContent = categoria_en;
                }
                

                //Generar el contenedor de la información del usuario
                const card = document.createElement('DIV');
                card.classList.add('p-cards__grid__item', 'card-public');

                //agregar la información al contenedor
                categoriaLink.appendChild(categoriaTitle);
                //agregar el link contenedor a la tarjeta
                card.appendChild(categoriaLink);
                //agregar el contenedor de la información al grid
                gridCategorias.appendChild(card);
        });
        filtraCategorias();
}

function filtraCategorias(){
        categoriasInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card-public');

                cards.forEach(card => {
                        const categoriaTitle = normalizeText(card.textContent);
                        if(categoriaTitle.indexOf(texto) !== -1){
                                card.style.display = 'block';
                        }else{
                                card.style.display = 'none';
                        }
                });
        });
        
}