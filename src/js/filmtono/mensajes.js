import { gridMensajes } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';

export async function consultaMensajes(){
    try{
        const resultado = await fetch(window.location.origin+'/api/filmtono/messages');
        const datos = await resultado.json();
        console.log(datos);
        mostrarMensajes(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarMensajes(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        datos.forEach(contacto => {
                const {id, nombre, apellido, email, pais, telefono, presupuesto, mensaje} = contacto;


                const divNombre = document.createElement('DIV');
                divNombre.classList.add('card__info--title', 'flex-icon');
    
                //generar la etiqueta para el nombre
                const nombreContacto = document.createElement('P');
                nombreContacto.classList.add('card__info--title');
                nombreContacto.textContent = nombre + ' ' + apellido;

                const iconoContacto = document.createElement('I');
                iconoContacto.classList.add('fa-solid', 'fa-user', 'no-click', 'text-yellow');

                divNombre.appendChild(iconoContacto);
                divNombre.appendChild(nombreContacto);
                
                const divContacto = document.createElement('DIV');
                divContacto.classList.add('card__info--title', 'flex-icon');

                //generar la etiqueta para el email
                const emailContacto = document.createElement('P');
                emailContacto.classList.add('card__info');
                emailContacto.textContent = email;

                const iconoEmail = document.createElement('I');
                iconoEmail.classList.add('fa-solid', 'fa-envelope', 'no-click', 'text-yellow');

                divContacto.appendChild(iconoEmail);
                divContacto.appendChild(emailContacto);

                const divPais = document.createElement('DIV');
                divPais.classList.add('card__info--title', 'flex-icon');

                const paisContacto = document.createElement('P');
                paisContacto.classList.add('card__info');
                paisContacto.textContent = pais;

                const iconoPais = document.createElement('I');
                iconoPais.classList.add('fa-solid', 'fa-globe', 'no-click', 'text-yellow');

                divPais.appendChild(iconoPais);
                divPais.appendChild(paisContacto);

                const divTelefono = document.createElement('DIV');
                divTelefono.classList.add('card__info--title', 'flex-icon');

                const telefonoContacto = document.createElement('P');
                telefonoContacto.classList.add('card__info');
                telefonoContacto.textContent = telefono;

                const iconoTelefono = document.createElement('I');
                iconoTelefono.classList.add('fa-solid', 'fa-phone', 'no-click', 'text-yellow');

                divTelefono.appendChild(iconoTelefono);
                divTelefono.appendChild(telefonoContacto);

                const divPresupuesto = document.createElement('DIV');
                divPresupuesto.classList.add('card__info--title', 'flex-icon');

                const presupuestoContacto = document.createElement('P');
                presupuestoContacto.classList.add('card__info');
                if(presupuesto === ''){
                    presupuestoContacto.textContent = alerts['undefined'][lang];
                }else{
                    presupuestoContacto.textContent = '$ ' + presupuesto;
                }

                const iconoPresupuesto = document.createElement('I');
                iconoPresupuesto.classList.add('fa-solid', 'fa-sack-dollar', 'no-click', 'text-yellow');

                divPresupuesto.appendChild(iconoPresupuesto);
                divPresupuesto.appendChild(presupuestoContacto);

                const divMensaje = document.createElement('DIV');
                divMensaje.classList.add('card__info--title', 'flex-icon');

                const mensajeContacto = document.createElement('P');
                mensajeContacto.classList.add('card__info');
                mensajeContacto.textContent = mensaje;

                const iconoMensaje = document.createElement('I');
                iconoMensaje.classList.add('fa-solid', 'fa-envelope', 'no-click', 'text-yellow');

                divMensaje.appendChild(iconoMensaje);
                divMensaje.appendChild(mensajeContacto);

                //generar el botón para eliminar el usuario
                const btnEliminar = document.createElement('BUTTON');
                btnEliminar.classList.add('btn-delete');
                btnEliminar.value = id;
                btnEliminar.dataset.role = 'filmtono';
                btnEliminar.dataset.item = 'messages';
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
                contenedorBotones.appendChild(btnEliminar);

                //Generar el contenedor de la información del usuario
                const card = document.createElement('DIV');
                card.classList.add('card');

                //agregar la información al contenedor

                card.appendChild(divNombre);
                card.appendChild(divContacto);
                card.appendChild(divPais);
                card.appendChild(divTelefono);
                card.appendChild(divPresupuesto);
                card.appendChild(divMensaje);
                card.appendChild(contenedorBotones);

                //agregar el contenedor de la información al grid
                gridMensajes.appendChild(card);
        });
        filtrarUsuarios();
}

function filtrarUsuarios(){
        const input = document.querySelector('#mensajes-search');
        input.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                        const nombre = normalizeText(card.textContent);
                        if(nombre.indexOf(texto) !== -1){
                                card.style.display = 'flex';
                                card.style.marginRight = '2rem';
                                gridMensajes.style.columnGap = '0';
                        }else{
                                card.style.display = 'none';
                        }
                });
        }); 
}