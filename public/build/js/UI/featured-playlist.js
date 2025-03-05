// featured-playlist.js
import { featuredPlaylist } from './selectores.js';
import { initializePlayer } from './videos.js';

export async function consultaFeatured() {
  try {
    const resultado = await fetch(window.location.origin + '/api/public/featured-playlist');
    const datos = await resultado.json();
    playlistFeatured(datos);
  } catch (error) {
    console.log(error);
  }
}

export function playlistFeatured(datos) {
  if (featuredPlaylist) {
    // Usamos los IDs existentes en el HTML: 'player', 'videoItems' y 'playAll'
    initializePlayer(datos, {
      playerId: 'player',
      videoItemsId: 'videoItems',
      playAllButtonId: 'playAll'
    });
  }
}
