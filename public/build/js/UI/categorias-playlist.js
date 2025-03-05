import { categoryButtons } from './selectores.js';
import { initializePlayer } from './videos.js';

// Variable global para almacenar la instancia del reproductor de la sección de categorías.
let categoryPlayerInstance = null;

export function setupCategoryButtons() {
  categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
      const categoryId = button.dataset.categoryId;
      fetchCategoryPlaylist(categoryId);
      updateActiveCategoryButton(categoryId);
    });
  });
  
  // Cargar automáticamente la primera categoría si existe
  if (categoryButtons.length > 0) {
    const firstCategoryId = categoryButtons[0].dataset.categoryId;
    fetchCategoryPlaylist(firstCategoryId);
    updateActiveCategoryButton(firstCategoryId);
  }
}

export async function fetchCategoryPlaylist(categoryId) {
    try {
      const response = await fetch(`${window.location.origin}/api/public/playlist-category?categoryId=${categoryId}`);
      const playlistData = await response.json();
  
      // Si el arreglo está vacío, mostramos un mensaje
      if (!playlistData || playlistData.length === 0) {
        document.getElementById('playerCategory').innerHTML = "<p>No hay videos para esta categoría.</p>";
        document.getElementById('videoItemsCategory').innerHTML = "";
        return;
      }
  
      // Destruir la instancia previa, si existe
      if (categoryPlayerInstance && typeof categoryPlayerInstance.destroy === 'function') {
        categoryPlayerInstance.destroy();
      }
  
      // Crear la nueva instancia; aquí se esperará hasta que el reproductor esté listo
      categoryPlayerInstance = await initializePlayer(playlistData, {
        playerId: 'playerCategory',
        videoItemsId: 'videoItemsCategory',
        playAllButtonId: 'playAllCategory'
      });
    } catch (error) {
      console.error('Error al cargar la playlist de la categoría:', error);
    }
  }
  
// Función para resaltar el botón de la categoría activa
function updateActiveCategoryButton(selectedCategoryId) {
  const categoryButtons = document.querySelectorAll('.category-btn');
  categoryButtons.forEach(button => {
    if (button.dataset.categoryId === selectedCategoryId) {
      button.classList.add('active');
    } else {
      button.classList.remove('active');
    }
  });
}

// Inicializar la configuración de botones al cargar el script
setupCategoryButtons();

