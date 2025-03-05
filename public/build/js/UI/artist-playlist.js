import {artistPlaylist} from './selectores.js';
import { initializePlayer } from './videos.js';

export async function consultaCancionesArtista(id){
    try{
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const id = params.get('id');
        const resultado = await fetch(window.location.origin+'/api/public/artist/'+'?id='+id);
        const datos = await resultado.json();
       playlistArtista(datos);
    }catch(error){
        console.log(error);
    }
}

export function playlistArtista(datos){
    if(artistPlaylist){
        initializePlayer(datos);
    }
}
