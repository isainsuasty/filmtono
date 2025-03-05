import {  artistasInput, portada, artistaSecundario, btnAgregar } from "./selectores.js";
import  {readLang, readJSON, validarFormulario} from "../base/funciones.js";

export function styleDatalist(){
    artistasInput.forEach(input => {
        input.onfocus = function(){
            input.nextElementSibling.style.display = 'block';
        }
        for(let option of input.nextElementSibling.options){
            option.classList.add('option');
            option.onclick = function(){
                input.value = option.value;
                input.nextElementSibling.style.display = 'none';
            }
        }
        //filter options on input
        input.oninput = function(){
            const text = input.value.toUpperCase();
            for (let option of input.nextElementSibling.options) {
                if(option.value.toUpperCase().indexOf(text) > -1){
                option.style.display = "block";
            }else{
                option.style.display = "none";
                }
            };
        }
        input.onclick = function(){
            input.nextElementSibling.style.display = 'block';
        }
    });
}

export function styleFileInput(){
    readLang().then(lang => {
        if(lang === 'es'){
            portada.forEach(cover => {
                cover.setAttribute('data-text', 'Selecciona un archivo');
            });
        } else{
            portada.forEach(cover => {
                cover.setAttribute('data-text', 'Select a file');
            });
        }
    });
}

export function artistasSecundarios(){
    let artistasList = artistaSecundario.nextElementSibling;
    for(let option of artistasList.options){        
        option.onclick = function(){
            let artistaId = artistaSecundario.id;
            let artistaName = artistaSecundario.name;
            
            artistaId = option.value;
            artistaName = option.textContent;
            agregarArtistaSecundario(artistaId, artistaName);   
            artistasList.style.display = 'none';
        }
        artistaSecundario.oninput = function(){
            const text = artistaSecundario.value.toUpperCase();
            for (let option of artistasList.options) {
                if(option.value.toUpperCase().indexOf(text) > -1){
                option.style.display = "block";
            }else{
                option.style.display = "none";
                }
            };
        }

    }
    
    const div = document.createElement('div');
    div.classList.add('form__custom__input--artistas');
    artistaSecundario.parentElement.insertBefore(div, artistaSecundario);
}

function agregarArtistaSecundario(artistaId, artistaName){
    //crear un objeto con keys id y name para almacenar los artistas

    //crear el div
    const div = document.querySelector('.form__custom__input--artistas');

    //Comprobar que el artista no esté ya en el div
    const artistasDiv = document.querySelectorAll('.form__custom__input--artistas__p');

    artistasDiv.forEach(artista => {
        if(artista.id === artistaId){
            artista.remove();
        }else{
            div.appendChild(artista);            
        }
    });
    //crear el parrafo con el nombre del artista

    const p = document.createElement('p');
    p.classList.add('form__custom__input--artistas__p');
    p.id = artistaId;
    p.textContent = artistaName;
    //crear el boton de eliminar
    const btnEliminar = document.createElement('button');
    btnEliminar.classList.add('btn-eliminar');
    btnEliminar.textContent = 'X';
    btnEliminar.id = artistaId;
    btnEliminar.onclick = function(){
        div.removeChild(p);
    }
    //agregar el boton al div
    
    p.appendChild(btnEliminar);
    div.appendChild(p);

    //remove the value from the array if removed from the div usind the X button and read the array value again   

    const btnEnviar = document.querySelector('#btn-artista');
    btnEnviar.addEventListener('click', function(e){
        //incrustar el valor del array en el input hidden
        const artistasArray = [];
        const artistas = document.querySelectorAll('.form__custom__input--artistas__p');
        artistas.forEach(artista => {
            artistasArray.push(artista.id);
        });
        const artistasInput = document.querySelector('#artsecundarios-hidden');
        artistasInput.value = artistasArray.toString();
        console.log(artistasInput.value);      
    });
}

export async function addArtist(){
    const lang = await readLang();
    const alerts = await readJSON();
    btnAgregar.addEventListener('click', function(e){
        e.preventDefault();
         //crear modal para agregar formulario de artista
        

        const body = document.querySelector('body');
        body.classList.add('overlay');

        const divModal = document.createElement('div');
        divModal.classList.add('register');

        const modal = document.createElement('div');
        modal.classList.add('register__modal');

        const btnCerrar = document.createElement('button');
        btnCerrar.classList.add('register__btn-cerrar');
        btnCerrar.innerHTML = '<i class="fas fa-times"></i>';
        btnCerrar.onclick = cerrarModal;


        const form = document.createElement('form');
        form.classList.add('register__form');
        form.id = 'form-artista';
        form.autocomplete = 'off';

        const h2 = document.createElement('h2');
        h2.classList.add('register__title');
        h2.textContent = alerts['addArtist'][lang];

        const divInput = document.createElement('div');
        divInput.classList.add('form__group');

        const label = document.createElement('label');
        label.classList.add('form__group__label');
        label.htmlFor = 'nombre';
        label.textContent = alerts['name'][lang];

        const input = document.createElement('input');
        input.classList.add('form__group__input');
        input.type = 'text';
        input.name = 'nombre';
        input.id = 'artista-nombre';
        input.addEventListener('blur', validarFormulario);
        input.placeholder = alerts['name'][lang];

        const sendBtn = document.createElement('input');
        sendBtn.classList.add('btn-submit');
        sendBtn.type = 'submit';
        sendBtn.value = alerts['add'][lang];
        sendBtn.onclick = enviarArtista;


        divInput.appendChild(label);
        divInput.appendChild(input);
        form.appendChild(h2);
        form.appendChild(divInput);
        form.appendChild(sendBtn);
        modal.appendChild(btnCerrar);
        modal.appendChild(form);

        divModal.appendChild(modal);
        body.appendChild(divModal);

    });
}

async function enviarArtista(){
    const input = document.querySelector('#artista-nombre');
    const nombre = input.value;
    const data = new FormData();

    data.append('nombre', nombre);

    try{
        
        const url = window.location.origin+'/api/albums/artistasNew';

        const respuesta = await fetch(url, {
            method: 'POST',
            body: data,
            mode: 'no-cors'
        });

        const resultado = await respuesta.json();        

        if(resultado.resultado){
            const lang = await readLang();
            console.log(lang);
            if(lang === 'es'){
                alert('Artista agregado correctamente');
            } else{
                alert('Artist added successfully');
            }
            window.location.reload();
        };
    }catch(error){
        const lang = await readLang();
        if(lang === 'es'){
            alert('Hubo un error');
        } else{
            alert('There was an error');
        }
    }
}

function cerrarModal(){
    const body = document.querySelector('body');
    const modal = document.querySelector('.register');
    body.classList.remove('overlay');
    modal.remove();
}
