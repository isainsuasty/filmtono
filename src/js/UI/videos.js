import { loadYouTubeIframeAPI } from './youtube-api.js';

export async function initializePlayer(videoData, config = {}) {
  const {
    playerId = 'player',
    videoItemsId = 'videoItems',
    playAllButtonId = 'playAll'
  } = config;

  // Limpiar el contenedor del reproductor para evitar iframes viejos
  const playerContainer = document.getElementById(playerId);
  if (playerContainer) {
    playerContainer.innerHTML = '';
  }

  // Cargar la API de YouTube (se asume que esta función retorna una promesa que se resuelve con window.YT)
  const YT = await loadYouTubeIframeAPI();

  // Retornamos una promesa que se resuelve cuando el reproductor ya está listo.
  return new Promise((resolve, reject) => {
    let currentVideoIndex = 0;
    let playAll = false;

    const player = new YT.Player(playerId, {
      height: '360',
      width: '100%',
      videoId: videoData[0].videoId,
      playerVars: {
        origin: window.location.origin
      },
      events: {
        onReady: onReady,
        onStateChange: (event) => onStateChange(event, videoData, player)
      }
    });

    function onReady(event) {
      // Una vez que el reproductor está listo, creamos la lista de videos y resolvemos la promesa.
      createVideoList(videoData, videoItemsId, playAllButtonId, player);
      resolve(player);
    }

    function onStateChange(event, videoData, player) {
      if (event.data === YT.PlayerState.PLAYING) {
        updateCurrentVideoClass();
      } else if (event.data === YT.PlayerState.ENDED) {
        if (playAll && currentVideoIndex < videoData.length - 1) {
          currentVideoIndex++;
          player.loadVideoById(videoData[currentVideoIndex].videoId);
        }
      } else if (event.data === YT.PlayerState.PAUSED || event.data === YT.PlayerState.CUED) {
        clearCurrentVideoClass();
      }
    }

    function createVideoList(videoData, containerId, playAllButtonId, player) {
      const videoItemsContainer = document.getElementById(containerId);
      videoItemsContainer.innerHTML = ''; // Limpiar contenido previo

      videoData.forEach((video, index) => {
        const videoItem = document.createElement('div');
        videoItem.className = 'video__items__item';
        videoItem.dataset.index = index;
        videoItem.addEventListener('click', () => {
          currentVideoIndex = index;
          playAll = false;
          player.loadVideoById(video.videoId);
        });

        const playButton = document.createElement('button');
        const playIcon = document.createElement('i');
        playIcon.className = 'fas fa-play';
        playButton.appendChild(playIcon);

        const videoTitle = document.createElement('span');
        videoTitle.textContent = video.title;

        videoItem.appendChild(videoTitle);
        videoItem.appendChild(playButton);
        videoItemsContainer.appendChild(videoItem);
      });

      // Asignar listener al botón "Play All"
      const playAllButton = document.getElementById(playAllButtonId);
      if (playAllButton) {
        playAllButton.addEventListener('click', () => {
          currentVideoIndex = 0;
          playAll = true;
          player.loadVideoById(videoData[0].videoId);
        });
      }
    }

    function updateCurrentVideoClass() {
      const videoItems = document.querySelectorAll(`#${videoItemsId} .video__items__item`);
      videoItems.forEach((item, index) => {
        if (index === currentVideoIndex) {
          item.classList.add('video__current');
        } else {
          item.classList.remove('video__current');
        }
      });
    }

    function clearCurrentVideoClass() {
      const videoItems = document.querySelectorAll(`#${videoItemsId} .video__items__item`);
      videoItems.forEach(item => item.classList.remove('video__current'));
    }
  });
}
