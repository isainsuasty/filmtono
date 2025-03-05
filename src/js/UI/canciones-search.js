import { gridCanciones, cancionesInput, artistaSelect, clearSearch, generoSelect, instrumentoSelect, categoriasSelect, idiomasSelect, nivelSelect, nivelArtistaSelect } from './selectores.js';
import { readLang, readJSON, loader, loaderPage, stopLoader, loaderTimer } from '../base/funciones.js';


export async function consultaCanciones() {
    if(gridCanciones){
        try {
            const url = window.location.origin + '/api/public/songs';
            const resultado = await fetch(url);
            const datos = await resultado.json();
            mostrarCanciones(datos);  // Show all songs initially
        } catch (error) {
            console.log(error);
        }
    }
}

async function mostrarCanciones(datos) {
    gridCanciones.innerHTML = '';  // Clear the grid before displaying new results

    const lang = await readLang();
    const alerts = await readJSON();

    datos.forEach(cancion => {
        const { id, titulo, url, artista_name } = cancion;

        const cardCancion = document.createElement('div');
        cardCancion.classList.add('main__artists__item');

        const cardVideo = document.createElement('IFRAME');
        cardVideo.classList.add('main__artists__video', 'margin-auto');
        cardVideo.src = 'https://www.youtube.com/embed/' + url + '?controls=0&showinfo=0&rel=0&autoplay=1&mute=1&loop=1&playlist=' + url;
        cardVideo.frameborder = '0';
        cardVideo.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        cardVideo.allowFullscreen = true;
        cardVideo.loading = 'lazy';

        const titleCancion = document.createElement('p');
        titleCancion.textContent = titulo;
        titleCancion.classList.add('cards__text', 'cards__text--span', 'text-yellow', 'text-24', 'center');

        const artistaCancion = document.createElement('p');
        artistaCancion.textContent = artista_name;
        artistaCancion.classList.add('cards__text', 'cards__text--span', 'text-green', 'text-24', 'center');

        cardCancion.appendChild(titleCancion);
        cardCancion.appendChild(cardVideo);
        cardCancion.appendChild(artistaCancion);

        gridCanciones.appendChild(cardCancion);
    });
}

let currentQuery = '';
let currentArtist = '';
let currentNivel = '';
let currentNivelArtista = '';
let currentGenero = '';
let currentInstrumento = '';
let currentCategoria = '';
let currentIdioma = '';
let selectedSubcategory = '';

async function filtraCanciones() {

    // Call the search and filter function when the page loads      
    // Listen for changes in the search input field
    cancionesInput.addEventListener('input', async (e) => {
        currentQuery = e.target.value.toLowerCase().trim();  // Update the query
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated query and current artist
    });

    // Listen for changes in the artist select dropdown
    artistaSelect.addEventListener('change', async (e) => {
        currentArtist = e.target.value;  // Update the artist filter
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated artist and current query
        loaderTimer();
    });

    nivelSelect.addEventListener('change', async (e) => {
        currentNivel = e.target.value;  // Update the nivel filter
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated nivel and current query
        loaderTimer();
    });

    nivelArtistaSelect.addEventListener('change', async (e) => {
        currentNivelArtista = e.target.value;  // Update the nivel filter
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated nivel and current query
        loaderTimer();
    });

    // Listen for changes in the genero select dropdown
    generoSelect.addEventListener('change', async (e) => {
        currentGenero = e.target.value;  // Update the genero filter
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated genero and current query
        loaderTimer();
    });

    // Listen for changes in the instrumento select dropdown
    instrumentoSelect.addEventListener('change', async (e) => {
        currentInstrumento = e.target.value;  // Update the instrumento filter
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated instrumento and current query
        loaderTimer();
    });

    // Listen for changes in the categorias select dropdown
    categoriasSelect.addEventListener('change', async (e) => {
        currentCategoria = e.target.value;  // Update the categoria filter
        loadSubcategories(currentCategoria);  // Pass the updated categoria and current query
        loaderTimer();
    });
      

    // Listen for changes in the idiomas select dropdown
    idiomasSelect.addEventListener('change', async (e) => {
        currentIdioma = e.target.value;  // Update the idioma filter
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);  // Pass the updated idioma and current query
        loaderTimer();
    });

    // Función para inicializar un custom select en un contenedor dado
    function initializeCustomSelect(container) {
        const headerEl = container.querySelector('.custom-select-header');
        const optionsContainer = container.querySelector('.custom-select-options');
        const hiddenSelect = container.querySelector('select');
        
        // Convertir las opciones del select oculto en un array de objetos
        const options = Array.from(hiddenSelect.options).map(opt => ({
        value: opt.value,
        text: opt.text,
        selected: false
    }));

    // Función para renderizar el dropdown de opciones
    function renderOptions() {
      optionsContainer.innerHTML = ''; // Limpiar opciones previas
      options.forEach((opt, index) => {
        const optionEl = document.createElement('span');
        optionEl.classList.add('custom-select-option');
        optionEl.textContent = opt.text;
        optionEl.dataset.value = opt.value;

        // Si la opción está seleccionada, se marca y se le agrega un botón "x"
        if (opt.selected) {
          optionEl.classList.add('selected');
          const removeBtn = document.createElement('span');
          removeBtn.classList.add('remove');
          removeBtn.textContent = ' x';
          removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleOption(index);
          });
          optionEl.appendChild(removeBtn);
        }

        // Al hacer click en la opción, se alterna su selección
        optionEl.addEventListener('click', (e) => {
          e.stopPropagation();
          toggleOption(index);
        });

        optionsContainer.appendChild(optionEl);
        const optionsContainerHeight = optionsContainer.clientHeight;
        const songsDashboard = document.querySelector('#search-songs-dashboard');
        songsDashboard.style.paddingBottom = optionsContainerHeight + 'px';
      });
    }


    // Función para alternar la selección de una opción
    function toggleOption(index) {
      options[index].selected = !options[index].selected;
      updateHiddenSelect();
      renderOptions();
      loaderTimer();
    }

    // Actualiza el <select> oculto en función de las opciones seleccionadas
    function updateHiddenSelect() {
        const selectedValues = options.filter(opt => opt.selected).map(opt => opt.value);
        const hiddenInput = document.querySelector('#searchSongsSubcategory');
        hiddenInput.value = selectedValues.join(',');  // Convert array to a string if multiple selected
        selectedSubcategory = hiddenInput.value;  // Update the selectedSubcategory variable
    
        fetchQuery(currentQuery, currentArtist, currentNivel, currentNivelArtista, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);
    }
  

    /********** Eventos en el Componente **********/
    // Al hacer click en el header: 
    // - Se cierran todos los custom selects (los que tengan la clase "active") excepto el actual
    // - Se alterna la clase "active" en el contenedor actual

    headerEl.addEventListener('click', (e) => {
      e.stopPropagation();
      document.querySelectorAll('.custom-select-container').forEach(c => {
        if (c !== container) {
          c.classList.remove('active');
        }
      });
      container.classList.toggle('active');
    });

    // Evita que clicks dentro del contenedor se propaguen (para no cerrar el dropdown)
    container.addEventListener('click', (e) => {
      e.stopPropagation();
    });

    // Inicializamos el componente: renderizamos opciones y tags
    renderOptions();
  }

  /***************** Función para cargar subcategorías *****************/
  // Se llama cuando se selecciona una categoría (el select normal de categorías)
  async function loadSubcategories(categoryId) {
    // Se asume que readLang() está definida y devuelve una promesa con el idioma ("en" o "es")
    const lang = await readLang();
    const alerts = await readJSON();
    try {
      // Se realiza la petición para obtener las subcategorías de la categoría seleccionada
      const response = await fetch(`${window.location.origin}/api/public/subcategories?categoryId=${categoryId}`);
      const subcategories = await response.json();

      // Obtenemos el wrapper donde se insertará el custom select de subcategorías
      const wrapper = document.getElementById('subcategories-wrapper');
      wrapper.classList.remove('subcategories-wrapper');
      // Vaciamos completamente el contenido para eliminar cualquier componente anterior
      wrapper.innerHTML = '';

      // Creamos un nuevo contenedor para el custom select
      let container = document.createElement('div');
      container.classList.add('custom-select-container' , 'active');
      container.innerHTML = `
        <div class="custom-select-header">`+alerts['selectSubcategory'][lang]+`</div>
        <div class="custom-select-options"></div>
        <select name="subcategoria[]" multiple style="display: none;"></select>
      `;
      wrapper.appendChild(container);

      // Llenamos el select oculto con las opciones de subcategorías
      const hiddenSelect = container.querySelector('select');
      hiddenSelect.innerHTML = '';
      subcategories.forEach(subcat => {
        const option = document.createElement('option');
        option.value = subcat.id;
        option.text = lang === 'en' ? subcat.keyword_en : subcat.keyword_es;
        hiddenSelect.appendChild(option);
      });

      // Inicializamos el custom select para este contenedor
      initializeCustomSelect(container);

    } catch (error) {
      console.error(alerts['error'][lang]+':', error);
    }
  }
}


export function tagsFilters(){
    document.addEventListener('DOMContentLoaded', () => {
        // Selecciona todos los contenedores de select customizados
        const allContainers = document.querySelectorAll('.custom-select-container');
      
        allContainers.forEach(container => {
          // Dentro de cada contenedor, buscamos sus elementos
          const headerEl = container.querySelector('.custom-select-header');
          const optionsContainer = container.querySelector('.custom-select-options');
          const hiddenSelect = container.querySelector('select'); // El select oculto dentro del contenedor
      
          // Convertir las opciones del select en un array de objetos con propiedad 'selected'
          const options = Array.from(hiddenSelect.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            selected: false
          }));
      
          // Función para renderizar las opciones en el dropdown
          function renderOptions() {
            optionsContainer.innerHTML = ''; // Limpiar opciones previas
      
            options.forEach((opt, index) => {
              const optionEl = document.createElement('span');
              optionEl.classList.add('custom-select-option');
              optionEl.textContent = opt.text;
              optionEl.dataset.value = opt.value;
      
              // Si la opción está seleccionada, marcarla y agregar botón "x"
              if (opt.selected) {
                optionEl.classList.add('selected');
                const removeBtn = document.createElement('span');
                removeBtn.classList.add('remove');
                removeBtn.textContent = ' x';
                removeBtn.addEventListener('click', (e) => {
                  e.stopPropagation();
                  toggleOption(index);
                });
                optionEl.appendChild(removeBtn);
              }
      
              // Al hacer click en la opción, alternar su selección
              optionEl.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleOption(index);
              });
      
              optionsContainer.appendChild(optionEl);
            });
          }
      
          // Función para alternar la selección de una opción
          function toggleOption(index) {
            options[index].selected = !options[index].selected;
            renderOptions();
            const hiddenInput = document.querySelector('#searchSongsLevel');
            const hiddenInput2 = document.querySelector('#searchArtistLevel');
            //llenar el input hidden con los valores seleccionados
            if(container.id === 'niveles-cancion'){
                hiddenInput.value = options.filter(opt => opt.selected).map(opt => opt.value);
            }else{
                hiddenInput2.value = options.filter(opt => opt.selected).map(opt => opt.value);
            }


            fetchQuery(currentQuery, currentArtist, currentNivel, currentGenero, currentInstrumento, currentCategoria, currentIdioma, selectedSubcategory);
          }


          // Actualiza el select oculto según las opciones seleccionadas
      
          // Al hacer click en el header se alterna la visibilidad del dropdown
          headerEl.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.custom-select-container.active').forEach(container => {
                container.classList.remove('active');
              });
            // Antes de abrir este select, cerramos los demás
            allContainers.forEach(c => {
              if (c !== container) {
                c.classList.remove('active');
              }
            });
            // Alterna la clase "active" en este contenedor
            container.classList.toggle('active');
          });
      
          // Evitar que clicks dentro del contenedor cierren el dropdown
          container.addEventListener('click', (e) => {
            e.stopPropagation();
          });
      
          // Inicializar: renderizar las opciones y los tags
          renderOptions();
        });
      
        // Evento global para cerrar todos los dropdown al hacer click fuera
        document.addEventListener('click', () => {
          allContainers.forEach(c => c.classList.remove('active'));
        });
      });
      
      
}

async function fetchQuery(query, artist, nivel, nivelArtista, genero, instrumento, categoria, idioma, subcategory) {
    let url = `/api/public/songs/search?`;

    if (query.length > 0) {
        url += `search=${query}`;
    }

    if (artist.length > 0) {
        if (query.length > 0) {
            url += `&`;
        }
        url += `artist=${artist}`;
    }

    if (nivel.length > 0) {
        if (query.length > 0 || artist.length > 0) {
            url += `&`;
        }
        url += `level=${nivel}`;
    }

    if (genero.length > 0) {
        if (query.length > 0 || artist.length > 0 || nivel.length > 0) {
            url += `&`;
        }
        url += `genre=${genero}`;
    }

    if (instrumento.length > 0) {
        if (query.length > 0 || artist.length > 0 || nivel.length > 0 || genero.length > 0) {
            url += `&`;
        }
        url += `instrument=${instrumento}`;
    }

    if (categoria.length > 0) {
        if (query.length > 0 || artist.length > 0 || nivel.length > 0 || genero.length > 0 || instrumento.length > 0) {
            url += `&`;
        }
        url += `category=${categoria}`;
    }

    if (idioma.length > 0) {
        if (query.length > 0 || artist.length > 0 || nivel.length > 0 || genero.length > 0 || instrumento.length > 0 || categoria.length > 0) {
            url += `&`;
        }
        url += `language=${idioma}`;
    }

    if(nivelArtista.length > 0){
        if (query.length > 0 || artist.length > 0 || nivel.length > 0 || genero.length > 0 || instrumento.length > 0 || categoria.length > 0 || idioma.length > 0) {
            url += `&`;
        }
        url += `artistlevel=${nivelArtista}`;
    }

    if(subcategory && subcategory.length > 0){
        if (query.length > 0 || artist.length > 0 || nivel.length > 0 || genero.length > 0 || instrumento.length > 0 || categoria.length > 0 || idioma.length > 0 || nivelArtista.length > 0) {
            url += `&`;
        }
        url += `category=${currentCategoria}&subcategory=${selectedSubcategory}`;
    }


    if (url === '/api/public/songs/search?') {
        return;  // Don't fetch if no filters are applied
    }

    // Send the request to the backend
    const response = await fetch(url);
    const filteredSongs = await response.json();  // Get filtered songs
    mostrarCanciones(filteredSongs);  // Display filtered songs
}

// Function to delete the filters and reset everything
if(clearSearch){
    loader(clearSearch);
    function deleteFilter() {
        // Trigger the input event manually to ensure the filter resets
        cancionesInput.dispatchEvent(new Event('input'));

        // Reset the artist select filter to the default state (empty or first option)
        artistaSelect.value = '';  // Set select input back to default (empty string)
    
        // Clear the search input field
        cancionesInput.value = '';

        // Reset the genero select filter to the default state (empty or first option)
        generoSelect.value = '';  // Set select input back to default (empty string)

        // Reset the instrumento select filter to the default state (empty or first option)
        instrumentoSelect.value = '';  // Set select input back to default (empty string)

        // Reset the categorias select filter to the default state (empty or first option)
        categoriasSelect.value = '';  // Set select input back to default (empty string)

        // Reset the idiomas select filter to the default state (empty or first option)
        idiomasSelect.value = '';  // Set select input back to default (empty string)
    
        // Clear the state variables and remove previous event listeners
        currentQuery = '';
        currentArtist = '';
        currentNivel = '';
        currentGenero = '';
        currentInstrumento = '';
        currentCategoria = '';
        currentIdioma = '';

        document.querySelectorAll('.custom-select-container.active').forEach(container => {
            container.classList.remove('active');
        });
    
        //reload the whole page
        location.reload();
    }
    
    // Call the search and filter function when the page loads
    filtraCanciones();
    
    // Ensure clear button works
    clearSearch.addEventListener('click', deleteFilter);
}
