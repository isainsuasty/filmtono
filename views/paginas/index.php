<main class="main">
    <div class="main__slider">
        <div class="main__slider__wrapper">
            <?php
                foreach($promos as $promo):?>
                    <div class="main__slider__item">
                    <?php 
                        //get the type of the file
                        $f = $promo->promos;
                        //get the first part of the type before the slash
                        $f = explode('.', $f);
                        //set the type of the file
                        $f = $f[1];
                    ?> 
                    <?php if($f == 'mp4' || $f == 'avi' || $f == 'mov'):?>
                        <video class="main__slider__video" src="/build/img/promos/<?php echo $promo->promos?>" autoplay loop muted></video>
                    <?php else:?>
                        <img class="main__slider__img" src="/build/img/promos/<?php echo $promo->promos?>" alt="" loading="lazy">
                    <?php endif;?>
                    </div>
                <?php endforeach; ?>
            
           
        </div>
        <div class="main__slider__controls">
            <button class="main__slider__btn main__slider__btn--prev" id="prev"><i class="fas fa-arrow-left"></i></button>
            <button class="main__slider__btn main__slider__btn--next" id="next"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
</main>

<!-- Section with the featured playlist -->
<section class="container" id="featured-playlist">
    <h2 class="main__subtitle">{%index_subtitle-featured%}</h2>
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

<!-- Sección de Playlist por Categoría -->
<section class="container" id="category-playlist">
  <h2 class="main__subtitle">{%index_subtitle-categories%}</h2>
  <div class="category-buttons">
    <?php foreach ($categorias as $categoria): ?>
      <button class="category-btn btn-filter" data-category-id="<?php echo $categoria->id ?>">
      <?php if($lang == 'es'){
          echo $categoria->categoria_es;
        }else{
            echo $categoria->categoria_en;
            }
        ?>
      </button>
    <?php endforeach; ?>
  </div>
  <div class="video__container">
    <div class="video__list">
      <button class="video__list__btn" id="playAllCategory">{%btn_play-all%}</button>
      <div class="video__items" id="videoItemsCategory"></div>
    </div>
    <div class="video__player">
      <div id="playerCategory"></div>
    </div>
  </div>
  <a href="/categories" class="btn-view--index mTop-5 text-24">{%index_btn-categories%}</a>
</section>

<!-- Section with the artists -->
<section class="container mTop-10">
    <h2 class="main__subtitle">{%index_subtitle-artists%}</h2>
    <div class="main__artists">
        <?php
            foreach($artists as $artist):?>
                <a class="main__artists__card" href="/artist?id=<?php echo $artist->id?>">
                    <div class="main__artists__item">
                        <!--video iframes-->
                        <?php if($artist->banner):?>
                            <iframe class="main__artists__video" src="https://www.youtube.com/embed/<?php echo $artist->banner?>?&autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php else:?>
                            <img class="main__artists__img" src="/build/img/artist.webp" alt="{%category-movies%}" loading="lazy">
                        <?php endif;?>

                        <p class="main__artists__nombre"><?php echo $artist->nombre?></p>
                    </div>
                </a>
            <?php endforeach; ?>
    </div>
    <a href="/artists" class="btn-view--index text-24">{%index_btn-artists%}</a>
</section>