import { generosInput, gridGeneros } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';

export async function consultaGeneros(){
    try{
        const resultado = await fetch(window.location.origin+'/api/filmtono/genres');
        const datos = await resultado.json();
        mostrarGeneros(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarGeneros(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        datos.forEach(genero => {
                const {id, genero_en, genero_es} = genero;

                //generar el link para la categoria
                const categoriaDiv = document.createElement('DIV');
                categoriaDiv.classList.add('cards__div');


                //generar la etiqueta para el tipo de usuario
                const generoTitle = document.createElement('H3');
                generoTitle.classList.add('card__info--title');
                if(lang == 'es'){
                        generoTitle.textContent = genero_es;
                }else{
                        generoTitle.textContent = genero_en;
                }

                const btnEditar = document.createElement('A');
                btnEditar.classList.add('btn-update');
                btnEditar.href = '/filmtono/genres/edit?id='+id;
                

                //generar ícono de lápiz para el botón de editar
                const iconoLapiz = document.createElement('I');
                iconoLapiz.classList.add('fa-solid', 'fa-pencil', 'no-click');

                //Agregar el ícono al botón
                btnEditar.appendChild(iconoLapiz);

                //generar el botón para eliminar el usuario
                const btnEliminar = document.createElement('BUTTON');
                btnEliminar.classList.add('btn-delete');
                btnEliminar.value = id;
                btnEliminar.dataset.role = 'filmtono';
                btnEliminar.dataset.item = 'genres';
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
                categoriaDiv.appendChild(generoTitle);
                categoriaDiv.appendChild(contenedorBotones);
                //agregar el Div contenedor a la tarjeta
                card.appendChild(categoriaDiv);
                //agregar el contenedor de la información al grid
                gridGeneros.appendChild(card);
        });
        filtrarGeneros();
}

function filtrarGeneros(){
        generosInput.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                        const generoTitle = normalizeText(card.textContent);
                        if(generoTitle.indexOf(texto) !== -1){
                                card.style.display = 'flex';
                                card.style.marginRight = '2rem';
                                gridGeneros.style.columnGap = '0';
                        }else{
                                card.style.display = 'none';
                        }
                });
        }); 
}