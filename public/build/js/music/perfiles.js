//Módulos importados
import { botones, pagAnterior, pagSiguiente, afterNav, btnContrato, nombre, email, cargo, telContacto, empresa, idFiscal, direccion, terms, privacy, divCheck, btnSubmit, paisContacto, telIndex, hiddenMusic, hiddenArtistic, contratoMusical, contratoArtistico, confirmContrato, confirmContratoArt, selectPais} from './selectores.js';
import { validarFormulario, imprimirAlerta, loader, readJSON, readLang } from '../base/funciones.js';


//Variables globales
let checkMusical = false;
let paso = 1;

//Funciones para el registro de empresa
//*Paginador y tabs

export function tabs() {
    validarTab1();
    botones.forEach(tab => {
        tab.addEventListener('click', function(e) {
            paso = e.target.dataset.paso;
            cambiarSeccion(e);
            botonesPaginador();
        });
    });
}
const secciones = document.querySelectorAll('.tabs__section');
function cambiarSeccion(e) {   
    const tabActivo = document.querySelector(`#paso-${paso}`);
    tabActivo.classList.add('mostrar');
    e.target.classList.add('active');
    let inputs;
    // Remueve la clase active de los botones
    if(tabActivo.id === 'paso-1'){
        botones[0].classList.add('active');
        botones[1].classList.remove('active');
        botones[2].classList.remove('active');
        secciones[0].classList.add('mostrar');
        secciones[1].classList.remove('mostrar');
        secciones[2].classList.remove('mostrar');
        inputs = [cargo, telContacto, paisContacto];
    } else if(tabActivo.id === 'paso-2'){
        botones[1].classList.add('active');
        botones[2].classList.remove('active');
        secciones[1].classList.add('mostrar');
        secciones[2].classList.remove('mostrar');
        secciones[0].classList.remove('mostrar');
        inputs = [empresa, idFiscal, direccion];
    } else{
        botones[1].classList.add('active');
        botones[2].classList.add('active');
        secciones[2].classList.add('mostrar');
        secciones[0].classList.remove('mostrar');
        secciones[1].classList.remove('mostrar');
    }
}

function validarTab(inputs){
    let tabActive = document.querySelector(".mostrar");

    if(tabActive.id === 'paso-2'){
    pagSiguiente.classList.add('btn-disabled');
    const arrayInputs = Array.from(inputs);
    //agregar event listener a los campos
        arrayInputs.forEach(input => {
            input.addEventListener('input', ()=>{
                if(arrayInputs.every( input => input.value !== '')){
                    pagSiguiente.classList.remove('btn-disabled');
                }else{
                    pagSiguiente.classList.add('btn-disabled');
                }
            });
        });  
    } //validar que el array de inputs no este vacio

}

function validarTab1(){
    const inputs = [cargo, telContacto, paisContacto];
    const arrayInputs = Array.from(inputs);

    //agregar event listener a los campos
    arrayInputs.forEach(input => {
        input.addEventListener('input', ()=>{
            if(arrayInputs.every( input => input.value !== '')){
                pagSiguiente.classList.remove('btn-tabs--disabled');
            }else{
                pagSiguiente.classList.add('btn-tabs--disabled');
            }
        });
    });   //validar que el array de inputs no este vacio

}

async function botonesPaginador(){ 
    const lang = await readLang();
    const alerts = await readJSON();

    switch(paso) {
        case '1':
            pagAnterior.classList.add('ocultar');
            pagSiguiente.classList.remove('ocultar');
            afterNav.classList.remove('step2');
            afterNav.classList.remove('step3');
            pagSiguiente.classList.remove('btn-tabs--disabled');
            break;
        case '2':
            pagAnterior.classList.remove('ocultar');
            pagSiguiente.classList.remove('ocultar');
            afterNav.classList.add('step2');
            afterNav.classList.remove('step3');
            pagSiguiente.classList.remove('btn-tabs--disabled');
            pagSiguiente.textContent = alerts['next'][lang]+' \u2713';
            break;
        case '3':
            pagAnterior.classList.remove('ocultar');
            pagSiguiente.textContent = alerts['register'][lang]+' \u2713';
            pagSiguiente.onclick = validarCheck;
            afterNav.classList.add('step3');
            afterNav.classList.remove('step2');
            if(btnContrato){
                btnContrato.forEach(btn => {
                    btn.onclick = modalContrato;
                });
            };
            break;
        default:
            break;
    }
}

export function paginador(){
    pagAnterior.addEventListener('click', paginaAnterior);
    pagSiguiente.addEventListener('click',paginaSiguiente);
}

function paginaSiguiente(){
    if(!botones[1].classList.contains('active')){
        botones[1].click();
        const inputs = [empresa, idFiscal, direccion];
        validarTab(inputs);
    } else if(!botones[2].classList.contains('active')){
        botones[2].click();
    }
}

function paginaAnterior(e){
    if(botones[2].classList.contains('active')){
        pagSiguiente.classList.remove('btn-disabled');
        botones[1].click();        
    } else if(botones[1].classList.contains('active')){
        pagSiguiente.classList.remove('btn-disabled');
        botones[0].click();        
    }
}

//Validación de formulario de registro de empresa
export function formularioReg(){
    cargo.addEventListener('blur', validarFormulario);
    telContacto.addEventListener('blur', validarFormulario);
    empresa.addEventListener('blur', validarFormulario);
    idFiscal.addEventListener('blur', validarFormulario);
    direccion.addEventListener('blur', validarFormulario);
}

function validarCheck(e){
    e.preventDefault();
    if(!terms.checked){
        alertaCheck('terms');
    } else if(!privacy.checked){
        alertaCheck('privacy');
    // } else if(btnContrato){
    //      if(checkMusical === false){
    //         alertaCheck('contract');
    //     }
    }
    else{
        //comprobar que todos los inputs tengan un valor
        const inputs = [cargo, telContacto, empresa, idFiscal,  direccion];
        const arrayInputs = Array.from(inputs);
        loader(btnSubmit);

        if(arrayInputs.every( input => input.value !== '')){
            btnSubmit.click();
            //Add loader function when clicking the submit button
        } else{
            alertaCheck('inputs');
        }
    }
}

async function alertaCheck(message){
    // Crea el div
    const divMensaje = document.createElement('div');
    divMensaje.classList.add('alerta__error');

    const error = document.querySelector('.alerta__error');
    if(error){
        error.remove();
    }
    // Mensaje de error
    const lang = await readLang();
    const alerts = await readJSON();

    divMensaje.textContent = alerts[message][lang];

    // Insertar en el DOM
    divCheck.appendChild(divMensaje);

    // Quitar el alert despues de 3 segundos
    setTimeout( () => {
        divMensaje.remove();
    }, 4000);
}

//Contrato para modal
async function getContrato(url){
    try{
        const res = await fetch(url);
        const data = await res.json();
        return data;        
    }catch(err){
        console.log(err);
    }
}

async function modalContrato(e){
    e.preventDefault();
        
    const lang = await readLang();
    const alerts = await readJSON();

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

    let url;
    if(e.target.id === 'contrato-musical'){
        url = window.location.origin+'/api/filmtono/c-musical';
    }else{
        url = window.location.origin+'/api/filmtono/c-artistico';
    }

    const divContrato = document.createElement('div');

    const contrato = await getContrato(url);
    divContrato.innerHTML = contrato;   

    const firmaTitulo = document.createElement('P');
    firmaTitulo.textContent = alerts.signature[lang];
    firmaTitulo.classList.add('firma');

    const firmaInfo = document.createElement('P');
    firmaInfo.textContent = alerts.signatureInfo[lang];
    firmaInfo.classList.add('firma__info');

    const formCanvas = document.createElement('form');

    const canvas = document.createElement('canvas');
    //find the screen width
    const width = window.innerWidth;
    //set the canvas width and height
    if(width < 600){
        canvas.width = 300;
        canvas.height = 150;
        }else{
        canvas.width = 600;
        canvas.height = 200;
    }
    canvas.style.border = '1px solid black';
    canvas.style.backgroundColor = 'white';
    canvas.style.margin = '0 auto';
    canvas.style.display = 'block';
    if(e.target.id === 'contrato-musical'){
        canvas.id = 'canvas-musical';
    }else{
        canvas.id = 'canvas-artistico';
    }

    const ctx = canvas.getContext("2d");
    ctx.fillStyle = "white";
    ctx.strokeStyle = "black";
    ctx.lineWidth = 2;
    ctx.lineCap = "round";

    let isDrawing = false;
    let x = 0;
    let y = 0;

    canvas.addEventListener("mousedown", startDrawing);
    canvas.addEventListener("mousemove", draw);
    canvas.addEventListener("mouseup", stopDrawing);
    canvas.addEventListener("touchstart", startDrawing);
    canvas.addEventListener("touchmove", draw);
    canvas.addEventListener("touchend", stopDrawing);

    function startDrawing(e) {
    isDrawing = true;
        if (e.touches) {
            body.style.overflow = 'hidden';
            [x, y] = [e.touches[0].pageX - e.target.offsetLeft, e.touches[0].pageY - e.target.offsetTop];
        } else {
            [x, y] = [e.offsetX, e.offsetY];
        }
    }

    //create a function for drawing on the canvas with the finger
   
    function draw(e) {
        if (!isDrawing) return;
        ctx.beginPath();
        if (e.touches) {
            ctx.moveTo(x, y);
            ctx.lineTo(e.touches[0].pageX - e.target.offsetLeft, e.touches[0].pageY - e.target.offsetTop);
            [x, y] = [e.touches[0].pageX - e.target.offsetLeft, e.touches[0].pageY - e.target.offsetTop];
        } else {
            ctx.moveTo(x, y);
            ctx.lineTo(e.offsetX, e.offsetY);
            [x, y] = [e.offsetX, e.offsetY];
        }
        ctx.stroke();
    }
    
    function stopDrawing() {
        body.style.overflow = 'auto';
        isDrawing = false;
        ctx.beginPath();
    }      

    function limpiar(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        canvas.isCanvasBlank = true;
        if(canvas.id === 'canvas-musical'){
            imprimirAlerta('signValidation', 'error', firmaInfo);
            sendBtn.classList.add('btn-tabs--disabled');
        }
    }

    const clearBtn = document.createElement('button');
    clearBtn.classList.add('btn-contrato--optional');
    clearBtn.textContent = alerts['clear'][lang];
    clearBtn.onclick = limpiar;


    const sendBtn = document.createElement('button');

    if(canvas.id === 'canvas-musical'){
        sendBtn.classList.add('btn-tabs', 'btn-tabs--disabled');
    }else{
        sendBtn.classList.add('btn-tabs');
    }

    sendBtn.textContent = alerts['save'][lang];
    sendBtn.onclick = canvasValidation(canvas, sendBtn);
    
    //add event listener to see if the canvas is empty

    formCanvas.appendChild(canvas);

    modal.appendChild(btnCerrar);
    modal.appendChild(divContrato);
    modal.appendChild(firmaTitulo);
    modal.appendChild(firmaInfo);
    modal.appendChild(formCanvas);
    modal.appendChild(clearBtn);
    modal.appendChild(sendBtn);

    divModal.appendChild(modal);
    body.appendChild(divModal);


    datosContrato(canvas);
    paisContrato();

}

async function canvasValidation(canvas, sendBtn){
    const lang = await readLang();
    const alerts = await readJSON();    

    canvas.addEventListener('mouseup', () => {
        if (!isCanvasBlank(canvas)) {
            if(canvas.id==='canvas-musical'){
                sendBtn.classList.remove('btn-tabs--disabled');
                contratoMusical.style.display = 'none';
                //contratoMusical.remove();
                confirmContrato.style.display = 'block';
                confirmContrato.textContent = alerts['confirm'][lang];
                checkMusical = true;
                hiddenMusic.value = canvas.toDataURL();
            }
            else{                
                contratoArtistico.style.display = 'none';
                confirmContratoArt.style.display = 'block';
                confirmContratoArt.textContent = alerts['confirm'][lang];
                hiddenArtistic.value = canvas.toDataURL();
            }
            sendBtn.onclick = cerrarModal;
        }
    });
}

function isCanvasBlank(canvas) {
    const context = canvas.getContext('2d');
    const pixelBuffer = new Uint32Array(
      context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
    );
    return !pixelBuffer.some(color => color !== 0);
}

async function paisContrato(){
    if(paisContacto.value !== '0'){
        const paisFirmas = document.querySelector('#pais_contacto_name');
        const lang = await readLang();
        const contPais = document.querySelector('#contract-pais');
        const url = `https://restcountries.com/v3.1/alpha/${paisContacto.value}`;
        fetch(url)
            .then(respuesta => respuesta.json())
            .then(datos => {
                if(lang === 'es'){
                    contPais.textContent = datos[0].translations.spa.common;
                    paisFirmas.value = datos[0].translations.spa.common;
                }else{
                    contPais.textContent = datos[0].name.common;
                    paisFirmas.value = datos[0].name.common;
                }

            });
    }
}

function datosContrato(canvas){
    const gridFirmas = document.querySelector('.grid-firmas');
    gridFirmas.classList.remove('no-display');

    const contEmpresa = document.querySelector('#contract-empresa');
    const contNombre = document.querySelector('#contract-nombre');
    const contIdFiscal = document.querySelector('#contract-id-fiscal');
    const contDireccion = document.querySelector('#contract-direccion');
    const contTelefono = document.querySelector('#contract-telefono');
    const contEmail = document.querySelector('#contract-email');
    const signature = document.getElementById('signature-img');

    contEmpresa.textContent = empresa.value;    
    contNombre.textContent = nombre.value;
    contIdFiscal.textContent = idFiscal.value;
    contDireccion.textContent = direccion.value;
    contTelefono.textContent = telIndex.value + telContacto.value;
    contEmail.textContent = email.value;    

    canvas.addEventListener('click', () => {     
        signature.src = canvas.toDataURL();
        signature.classList.remove('no-display');
    });
}

function cerrarModal(){
    const body = document.querySelector('body');
    const modal = document.querySelector('.register');
    body.classList.remove('overlay');
    modal.remove();
}