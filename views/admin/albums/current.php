<a href="/filmtono/albums" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_albums-back_btn%}
</a>

<h1><?php echo $album->titulo;?></h1>

<div class="music__grid mTop-5">
    <img src="/portadas/<?php echo $album->portada;?>" alt="portada" class="" style="max-width:35rem;" loading="lazy">

    <div class="music__info">
        <div class="music__detail">
            <p class="caps"><span class="text-yellow">{%music_albums_artist_label%}: </span><?php echo $artista->nombre;?></p>
            <?php if($art_secundarios): ?>
                <p class="caps"><span class="text-yellow">{%music_albums_artist-secondary_label%}: </span><?php echo $art_secundarios->artistas;?></p>
            <?php endif; ?>
            <p class="caps"><span class="text-yellow">{%music_albums_upc_label%}: </span><?php echo $album->upc;?></p>
            <p class="caps"><span class="text-yellow">{%t-label%}: </span><?php echo $album->sello;?></p>
            <p class="caps"><span class="text-yellow">{%t-publisher%}: </span><?php echo $album->publisher;?></p>
            <p class="caps"><span class="text-yellow">{%t-rec-date%}: </span><?php echo $album->fecha_rec;?></p>
            <p class="caps"><span class="text-yellow">{%music_albums-languages%}: </span>
            <?php echo $idiomas;?></p>
        </div>        
    </div>
</div>

<div class="music-table mTop-5">
    <div class="dashboard__total">
        <p><span>{% music_songs_total %}: <?php echo count($songs) ?></span> </p>    

        <div class="dashboard__search">
            <input class="dashboard__total__type-search" type="text" id="songs-search" placeholder="{% music_songs_search-placeholder %}"/>
        </div>
    </div>

    <?php if(count($songs) > 0): ?>
        <div class="cards__container mTop-5" id="grid-songs">
        </div>
    <?php else: ?>
        <p>{%music_songs_empty%}</p>
    <?php endif; ?>
</div>