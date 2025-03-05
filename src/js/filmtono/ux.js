import { promoInput, promoLabel } from './selectores.js';

//funcion to read the name of the file to upload and display it in the input
export function readFileName(){    
    promoInput.addEventListener('change', () => {
        promoLabel.textContent = promoInput.files[0].name;
    });
}