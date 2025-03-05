import { selectLang, divLang, btnLang } from './selectores.js';

export function chooseLang(){    
    divLang.onclick = function(){
        selectLang.classList.toggle('no-display');
    }

    btnLang.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const lang = e.target.value;
            // Create a URL object based on the current location
            const currentUrl = new URL(window.location);
            // Access the URL's search parameters
            const searchParams = currentUrl.searchParams;
            // Set or update the 'lang' parameter
            searchParams.set('lang', lang);
            // Update the search property of the main URL
            currentUrl.search = searchParams.toString();
            // Redirect to the new URL
            window.location.href = currentUrl.href;
        });
    });
}
