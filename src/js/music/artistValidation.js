import { validateUrl } from "../base/funciones.js";
import { formArtist, url } from "./selectores.js";

export function validateArtistForm() {
    url.forEach( input => {
        input.addEventListener('blur', validateUrl);
    });
};
