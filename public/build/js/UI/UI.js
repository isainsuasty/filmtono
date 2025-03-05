
import { dropdownDiv, dropdownMenu, dropdownBtn, passbtn, mensajeInput} from "./selectores.js";
import { nextBtn, prevBtn, wrapper } from "./selectores.js";
import { readLang, readJSON, loaderPage, stopLoader} from '../base/funciones.js';

export function UI(){
    dropdownDiv.onmouseover = function(){
        dropdownMenu.classList.remove('no-display');
        dropdownBtn.classList.add('active');
    };
    dropdownMenu.onmouseout = function(){
        dropdownMenu.classList.add('no-display');
        dropdownBtn.classList.remove('active');
    }
}

export function showPassword(){
    passbtn.forEach(btn => {
        btn.addEventListener('click', () => {
            if(btn.classList.contains('fa-eye-slash')){
                btn.classList.remove('fa-eye-slash');
                btn.classList.add('fa-eye');
                btn.previousElementSibling.type = 'password';
            }else{
                btn.classList.remove('fa-eye');
                btn.classList.add('fa-eye-slash');
                btn.previousElementSibling.type = 'text';
            }
        });
    });
}

//Function for main slider on index.php
export function mainSlider() {
    const slides = document.querySelectorAll('.main__slider__item');
    let slideWidth = slides[0].clientWidth;
    let counter = 0;
    const time = 7000;

    // Function to update active class on slides
    const updateActiveClass = () => {
        slides.forEach((slide, index) => {
            slide.classList.toggle('main__slider__item--active', index === counter);
        });
    };
    

    const updateButtonStates = () => {
        prevBtn.disabled = counter <= 0;
        prevBtn.classList.toggle('main__slider__btn--disabled', counter <= 0);
        nextBtn.disabled = counter >= slides.length - 1;
        nextBtn.classList.toggle('main__slider__btn--disabled', counter >= slides.length - 1);
    };

    updateButtonStates(); // Set the initial state of the buttons
    updateActiveClass();  // Update the active class on initial load

    const moveSlide = () => {
        if (counter >= slides.length - 1) counter=-1; // Prevent going beyond the last slide
        counter++;
        wrapper.style.transition = 'transform 0.5s ease-in-out';
        wrapper.style.transform = `translateX(${-slideWidth * counter}px)`;
        updateButtonStates();
        updateActiveClass();
    };

    const moveSlideBack = () => {
        if (counter <= 0) return; // Prevent going before the first slide
        counter--;
        wrapper.style.transition = 'transform 0.5s ease-in-out';
        wrapper.style.transform = `translateX(${-slideWidth * counter}px)`;
        updateButtonStates();
        updateActiveClass();
    };

    // Automatic sliding
    let autoSlideInterval = setInterval(moveSlide, time);

    // Stop the automatic sliding when manual navigation is used
    const stopAutoSlide = () => {
        clearInterval(autoSlideInterval);
    };
    
    nextBtn.addEventListener('click', () => {
        moveSlide();
        stopAutoSlide();
    });
    
    prevBtn.addEventListener('click', () => {
        moveSlideBack();
        stopAutoSlide();
    });
    
    window.addEventListener('resize', () => {
        slideWidth = slides[0].clientWidth;
        wrapper.style.transform = `translateX(${(-slideWidth * counter)}px)`;
        updateActiveClass();
    });
}    

export async function mensaje(){
    const lang = await readLang();
    const alerts = await readJSON();
    const btnSubmit = document.querySelector('.btn-submit');
    mensajeInput.addEventListener('input', () => {
         //crear un mensaje con los caracteres restantes
    const mensajeMax = document.createElement('P');
    mensajeMax.classList.add('mensaje-max');
        //restar de 200 los caracteres introducidos
        let mensaje = mensajeInput.value.length;
        if(mensaje > 200){
            mensajeMax.textContent = alerts['max-characters-exceeded'][lang];
        } else{
            mensajeMax.textContent = (200 - mensaje) +' '+ alerts['characters-remaining'][lang];
        }
        //Agregar el mensaje al formulario eliminando el anterior
        const mensajeAnterior = document.querySelector('.mensaje-max');
        if(mensajeAnterior){
            mensajeAnterior.remove();
        }
        mensajeInput.parentElement.appendChild(mensajeMax);

        if(mensajeInput.value.length > 200){
            mensajeInput.style.color = '#ff3939';
            mensajeMax.style.color = '#770505';
            mensajeMax.style.backgroundColor = 'rgba(255, 255, 255, 0.75)';
            mensajeMax.style.border = '1px solid #ff3939';
            mensajeMax.style.borderRadius = '5px';
            mensajeMax.style.paddingLeft = '0.5rem';
            btnSubmit.classList.add('disabled-btn');
        } else {
            mensajeInput.style.color = 'white';
            mensajeMax.style.color = '#36DE8C';
            mensajeMax.style.backgroundColor = 'transparent';
            mensajeMax.style.border = 'none';
            mensajeMax.style.paddingLeft = '0';
            btnSubmit.classList.remove('disabled-btn');
        }
    });
}




export default UI;