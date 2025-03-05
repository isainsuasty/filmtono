// youtube-api.js
export function loadYouTubeIframeAPI() {
    return new Promise((resolve, reject) => {
        // Check if the API script is already loaded
        if (window.YT && window.YT.Player) {
            resolve(window.YT);
            return;
        }

        // Create a script element to load the YouTube IFrame Player API
        const tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        tag.onload = () => {
            window.onYouTubeIframeAPIReady = () => {
                resolve(window.YT);
            };
        };
        tag.onerror = (error) => reject(error);

        // Insert the script element into the DOM
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    });
}