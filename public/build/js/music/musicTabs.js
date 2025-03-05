import { albumsBlock, singlesBlock, albumsBtn, singlesBtn } from "./selectores.js";

export function musicTabs(){
    albumsBtn.addEventListener('click', showAlbums);
    singlesBtn.addEventListener('click', showSingles);
}

function showAlbums(e){
    e.preventDefault();
    albumsBlock.classList.remove('tabs__music--disabled');
    singlesBlock.classList.add('tabs__music--disabled');
    albumsBtn.classList.add('tabs__music__buttons--btn--active');
    singlesBtn.classList.remove('tabs__music__buttons--btn--active');
}

function showSingles(e){
    e.preventDefault();
    albumsBlock.classList.add('tabs__music--disabled');
    singlesBlock.classList.remove('tabs__music--disabled');
    albumsBtn.classList.remove('tabs__music__buttons--btn--active');
    singlesBtn.classList.add('tabs__music__buttons--btn--active');
}