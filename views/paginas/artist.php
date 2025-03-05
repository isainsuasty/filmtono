<div class="artist mTop-5">
    <div class="artist__banner">
        <?php if($artista->banner):?>
            <iframe class="artist__banner__video" src="https://www.youtube.com/embed/<?php echo $artista->banner;?>?&autoplay=1&mute=1&loop=1&playlist=<?php echo $artista->banner;?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php else:?>
            <img class="artist__banner__img" src="/build/img/artist.webp" alt="{%category-movies%}" loading="lazy">
        <?php endif;?>
    </div>

    <section class="artist__info">
        <div class="artist__text">
            <h1 class="artist__title"><?php echo $artista->nombre?></h1>
            <a class="artist__website" href="<?php echo $artista->website;?>" target="_blank"><?php echo $artista->website?></a>
        </div>
        <div class="artist__social">
            <?php if($artista->facebook):?>
                <a class="artist__social__link" href="<?php echo $artista->facebook;?>" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
            <?php endif;?>
            <?php if($artista->instagram):?>
                <a class="artist__social__link" href="<?php echo $artista->instagram;?>" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            <?php endif;?>
            <?php if($artista->twitter):?>
                <a class="artist__social__link" href="<?php echo $artista->twitter;?>" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
            <?php endif;?>
            <?php if($artista->youtube):?>
                <a class="artist__social__link" href="<?php echo $artista->youtube;?>" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
            <?php endif;?>
            <?php if($artista->spotify):?>
                <a class="artist__social__link" href="<?php echo $artista->spotify;?>" target="_blank">
                    <i class="fab fa-spotify"></i>
                </a>
            <?php endif;?>
            <?php if($artista->tiktok):?>
                <a class="artist__social__link" href="<?php echo $artista->tiktok;?>" target="_blank">
                    <i class="fab fa-tiktok"></i>
                </a>
            <?php endif;?>
        </div>
    </section>

    <?php
    if(!empty($songs)):?>
    <!-- Section with the artist's playlist -->
    <section class="container" id="artist-playlist">
        <h2 class="main__subtitle">{%artist_subtitle-songs%}</h2>
        <div class="video__container">
            <div class="video__list">
                <button class="video__list__btn" id="playAll">{%btn_play-all%}</button>
                <div class="video__items" id="videoItems"></div>
            </div>
            <div class="video__player">
                <div id="player"></div>
            </div>
        </div>
    </section>
    <?php else:?>
        <p class="artist__no-songs">{%artist_no-songs%}</p>
    <?php endif;?>
</div>
