import { loaderPage, validarFormulario, stopLoader } from "../base/funciones.js";
import { selectPais, paisContacto, indicativo, countrySelected, paisValue } from "./selectores.js";
import  {readLang} from "../base/funciones.js";

export async function consultaPaises(){
    try{
        loaderPage();
        setTimeout(() => {
            stopLoader();
        }, 1500);
        const url = window.location.origin+'/api/filmtono/countries';

        const resultado = await fetch(url);
        const datos = await resultado.json();
        mostrarPaises(datos);
         // 2000 milliseconds = 2 seconds
    }catch(error){
        console.log(error);
    }
}


function mostrarPaises(datos){
    // selected.textContent = datos[0].name.common;
    readLang().then(lang => {
            if(lang === 'es'){
                datos.forEach(pais => {
                    //ordenar los paises por orden alfabético
                    datos.sort((a, b) => {
                        if(a.translations.spa.common < b.translations.spa.common){
                            return -1;
                        }
                        if(a.translations.spa.common > b.translations.spa.common){
                            return 1;
                        }
                        return 0;
                    });
                    //crear option con el nombre del pais
                    const option = document.createElement('option');
                    option.value = pais.cca2;
                    option.textContent = pais.translations.spa.common;
                    option.setAttribute('data-pais', pais.translations.spa.common);
                    selectPais.appendChild(option);
                    if(paisContacto){
                        paisContacto.appendChild(option.cloneNode(true));
                    }
                });
            } else{
                datos.forEach(pais => {
                    //ordenar los países por orden alfabético
                    datos.sort((a, b) => {
                        if(a.name.common < b.name.common){
                            return -1;
                        }
                        if(a.name.common > b.name.common){
                            return 1;
                        }
                        return 0;
                    });

                    //crear option con el nombre del pais
                    const option = document.createElement('option');
                    option.value = pais.cca2;
                    option.textContent = pais.name.common;
                    if(selectPais){
                        selectPais.appendChild(option);  
                    }
                    if(paisContacto){
                        paisContacto.appendChild(option.cloneNode(true));
                    }
                });
            }
        }
    );
}

export function paisElegido(){
    if(selectPais){
        selectPais.addEventListener('blur', validarFormulario);
    }
    if(paisContacto){
        paisContacto.addEventListener('blur', validarFormulario);
    }
}

export function indicativoTel(){
    paisContacto.addEventListener('change', function(e){
        if(e.target.value !== ''){
            //consultar API para obtener el indicativo
            const url = `https://restcountries.com/v3.1/alpha/${e.target.value}`;
            fetch(url)
                .then(respuesta => respuesta.json())
                .then(datos => {      
                    //leer longitud de un array
                    console.log();              
                    if(Object.keys(datos[0].idd).length === 0){
                        indicativo.value = '0-';
                    } else{
                        const root = datos[0].idd.root;
                        const suffix = datos[0].idd.suffixes[0];
                        indicativo.value = `${root}${suffix}`;
                        indicativo.setAttribute('readonly', 'readonly');
                        indicativo.setAttribute('value', `${root}${suffix}`);
                    }
                });
        }
    });
}

export function countryCurrentValue(){
    const url = `https://restcountries.com/v3.1/alpha/${countrySelected.value}`;
    fetch(url)
        .then(respuesta=> respuesta.json())
        .then(datos => {
            readLang().then(lang => {
                if(lang === 'es'){
                    countrySelected.textContent = datos[0].translations.spa.common;
                } else{
                    countrySelected.textContent = datos[0].name.common;
                }
            });
        });
}

export function countryValue(){
    paisValue.forEach(pais => {
        const url = `https://restcountries.com/v3.1/alpha/${pais.id}`;
    fetch(url)
        .then(respuesta=> respuesta.json())
        .then(datos => {
            readLang().then(lang => {
                if(lang === 'es'){
                    pais.textContent = datos[0].translations.spa.common;
                } else{
                    pais.textContent = datos[0].name.common;
                }
            });
        });
    });
}

