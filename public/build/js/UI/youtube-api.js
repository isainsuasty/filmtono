// youtube-api.js
let apiPromise = null;

export function loadYouTubeIframeAPI() {
  if (apiPromise) return apiPromise;

  apiPromise = new Promise((resolve, reject) => {
    // Create script tag
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // This function gets called when the API is ready.
    window.onYouTubeIframeAPIReady = () => {
      resolve(window.YT);
    };

    // Optionally, handle errors:
    tag.onerror = reject;
  });

  return apiPromise;
}
