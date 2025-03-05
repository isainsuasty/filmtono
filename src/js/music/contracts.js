import { imprimirAlerta, loader, readJSON, readLang } from "../base/funciones.js";
import { btnContratoDash, dashboardEnlaces } from "./selectores.js";

export function blockDashboard(){
    btnContratoDash.forEach(btn => {
        if(btn.id === 'music'){
            dashboardEnlaces.forEach(enlace => {
                if(enlace.id === 'labels' || enlace.id === 'music' || enlace.id === 'artists'){
                    enlace.classList.add('dashboard__enlace--disabled');
                }
            });
        }
    });
}

export function signContract(){
    btnContratoDash.forEach(btn => {
        btn.onclick = modalContrato;
    });
}

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
    if(e.target.id === 'music'){
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
        imprimirAlerta('signValidation', 'error', firmaInfo);
        sendBtn.classList.add('btn-tabs--disabled');
    }

    //Create hidden input to store the image
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.id = 'signatureInput';
    hiddenInput.name = 'signatureInput';

    const clearBtn = document.createElement('button');
    clearBtn.classList.add('btn-contrato--optional');
    clearBtn.textContent = alerts['clear'][lang];
    clearBtn.onclick = limpiar;

    const tipo = e.target.id;
    const usuario = e.target.dataset.u;

    const sendBtn = document.createElement('button');
    sendBtn.classList.add('btn-tabs', 'btn-tabs--disabled');   
    sendBtn.textContent = alerts['save'][lang];
    sendBtn.onclick = canvasValidation(canvas, sendBtn, hiddenInput, tipo, usuario);
    
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
}

async function canvasValidation(canvas, sendBtn, hiddenInput, tipo, usuario){
    canvas.addEventListener('mouseup', () => {
        if (!isCanvasBlank(canvas)) {
            sendBtn.classList.remove('btn-tabs--disabled');
            hiddenInput = canvas.toDataURL();
            sendBtn.addEventListener('click', () => {
                loader(sendBtn);
                enviarImagen(hiddenInput, tipo, usuario);
            });
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

async function enviarImagen(hiddenInput, tipo, usuario){

    const datos = new FormData();
    datos.append('hiddenInput', hiddenInput);
    datos.append('tipo', tipo);
    datos.append('usuario', usuario);

    try{
        const url = window.location.origin+'/api/filmtono/signature';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        if(resultado.resultado){
            window.location.reload();
        };
    }catch(error){
        console.error('Error:', error);
    };
}

function cerrarModal(){
    const body = document.querySelector('body');
    const modal = document.querySelector('.register');
    body.classList.remove('overlay');
    modal.remove();
}