import { gridUsuarios } from './selectores.js';
import { readLang, readJSON, eliminarItem, normalizeText } from '../base/funciones.js';

export async function consultaUsuarios(){
    try{
        const resultado = await fetch(window.location.origin+'/api/filmtono/users');
        const datos = await resultado.json();
        mostrarUsuarios(datos);

    }catch(error){
        console.log(error);
    }
}
export async function mostrarUsuarios(datos){
        const lang = await readLang();
        const alerts = await readJSON();
        datos.forEach(usuario => {
                const {id, nombre, apellido, email, confirmado, perfil, nivel, tipo_es, tipo_en, empresa, aprobado} = usuario;

                //generar la etiqueta para el tipo de usuario
                const tipoUsuario = document.createElement('H3');
                tipoUsuario.classList.add('card__title');
                if(nivel != null){
                        if(lang === 'es'){
                                tipoUsuario.textContent = tipo_es;
                        } else {
                                tipoUsuario.textContent = tipo_en;
                        }
                }else{
                        tipoUsuario.textContent = 'Admin';
                }
                
                //generar la etiqueta para la empresa
                const empresaUsuario = document.createElement('P');
                empresaUsuario.classList.add('card__info--title');
                empresaUsuario.textContent = empresa;


                //generar la etiqueta para el nombre
                const nombreUsuario = document.createElement('P');
                nombreUsuario.classList.add('card__info');
                nombreUsuario.textContent = nombre + ' ' + apellido;
                
                //generar la etiqueta para el email
                const emailUsuario = document.createElement('P');
                emailUsuario.classList.add('card__info');
                emailUsuario.textContent = email;

                //generar la etiqueta para el estado
                const estadoUsuario = document.createElement('P');
                estadoUsuario.classList.add('card__info--span');
                if(confirmado==='1'){
                        estadoUsuario.textContent = alerts['confirmed'][lang];
                } else{
                        estadoUsuario.textContent = alerts['not-confirmed'][lang];
                }

                const estadoPerfil = document.createElement('P');
                estadoPerfil.classList.add('card__info--span');
                if(perfil==='1'){
                        estadoPerfil.textContent = alerts['profile-complete'][lang];
                } else {
                        estadoPerfil.textContent = alerts['profile-incomplete'][lang];
                }

                const estadoAprobado = document.createElement('P');
                estadoAprobado.classList.add('card__info', 'text-green');
                if(aprobado==='1'){
                        estadoAprobado.textContent = alerts['approved'][lang];
                } else {
                        estadoAprobado.textContent = alerts['pending-approval'][lang];
                }

                //generar el botón para aprobar el usuario
                
                const btnAprobar = document.createElement('BUTTON');
                btnAprobar.classList.add('btn-back');
                btnAprobar.value = id;
                btnAprobar.dataset.role = 'filmtono';
                btnAprobar.dataset.item = 'users';
                btnAprobar.onclick = aprobarUsuario;

                //generar ícono de check para el botón de aprobar
                const iconoCheck = document.createElement('I');
                iconoCheck.classList.add('fa-solid', 'fa-check', 'no-click');

                //Agregar el ícono al botón
                
                btnAprobar.appendChild(iconoCheck);

                //generar el botón para abir el modal con la información del usuario
                const btnInfo = document.createElement('A');
                btnInfo.classList.add('btn-view', 'mBottom-1');
                btnInfo.textContent = alerts['see-more'][lang];
                btnInfo.href = `/filmtono/users/current?id=${id}`;
                

                //generar el botón para eliminar el usuario
                const btnEliminar = document.createElement('BUTTON');
                btnEliminar.classList.add('btn-delete');
                btnEliminar.value = id;
                btnEliminar.dataset.role = 'filmtono';
                btnEliminar.dataset.item = 'users';
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
                if(aprobado !=='1'){
                        contenedorBotones.appendChild(btnAprobar);
                }
                contenedorBotones.appendChild(btnInfo);
                contenedorBotones.appendChild(btnEliminar);

                //Generar el contenedor de la información del usuario
                const card = document.createElement('DIV');
                card.classList.add('card');

                //agregar la información al contenedor
                card.appendChild(tipoUsuario);
                if(empresa){
                        card.appendChild(empresaUsuario);
                }
                card.appendChild(nombreUsuario);
                card.appendChild(emailUsuario);
                card.appendChild(estadoUsuario);
                if(nivel != null){
                        card.appendChild(estadoPerfil);
                }
                card.appendChild(estadoAprobado);
                card.appendChild(empresaUsuario);
                card.appendChild(contenedorBotones);

                //agregar el contenedor de la información al grid
                gridUsuarios.appendChild(card);
        });
        filtrarUsuarios();
}

function filtrarUsuarios(){
        const input = document.querySelector('#usuario-search');
        input.addEventListener('input', e => {
                const texto = normalizeText(e.target.value);
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                        const nombre = normalizeText(card.textContent);
                        if(nombre.indexOf(texto) !== -1){
                                card.style.display = 'flex';
                                card.style.marginRight = '2rem';
                                gridUsuarios.style.columnGap = '0';
                        }else{
                                card.style.display = 'none';
                        }
                });
        }); 
}

function aprobarUsuario(){
        //Enviar el post para aprobar el usuario
        const id = this.value;
        const role = this.dataset.role;
        const item = this.dataset.item;
        const data = new FormData();
        data.append('id', id);
        data.append('role', role);
        data.append('item', item);
        fetch(window.location.origin+'/api/filmtono/aprobar-usuario', {
                method: 'POST',
                body: data
        })
        .then(response => response.json())
        .then(data => {
                if(data.resultado){
                        window.location.reload();
                }
        })
        .catch(error => console.log(error));
}