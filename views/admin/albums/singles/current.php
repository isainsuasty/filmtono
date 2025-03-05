<a href="/filmtono/albums" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_singles-back_btn%}
</a>

<h1><?php echo $song->titulo;?></h1>

<div class="mTop-5">
    <iframe class="margin-auto min-height-45" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $song->url?>?si=pyomjURm8bMhB1-j" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

    <div class="music__grid mTop-5">
        <div class="music__info">
            <p class="caps"><span class="text-yellow">{%artist-title%}: </span><?php echo $song->artista_name;?></p>

            <p class="caps"><span class="text-yellow">{%version%}: </span><?php echo $song->version;?></p>

            <p class="caps"><span class="text-yellow">{%isrc%}: </span><?php echo $song->isrc;?></p>

            <p class="caps"><span class="text-yellow">{%label%}: </span><?php echo $song->sello;?></p>

            <?php if($lang == '_en'): ?>
                <p class="caps"><span class="text-yellow">{%song_level%}: </span><?php echo $song->nivel_cancion_en;?></p>
            <?php else: ?>
                <p class="caps"><span class="text-yellow">{%song_level%}: </span><?php echo $song->nivel_cancion_es;?></p>
            <?php endif; ?>

            <?php if($lang == '_en'): ?>
                <p class="caps"><span class="text-yellow">{%genre%}: </span><?php echo $song->genero_en;?></p>
            <?php else: ?>
                <p class="caps"><span class="text-yellow">{%genre%}: </span><?php echo $song->genero_es;?></p>
            <?php endif; ?>
            <?php if (!empty($song->categorias_en)): ?>
                <?php if($lang == '_en'): ?>
                    <p class="caps"><span class="text-yellow">{%categories%}: </span><?php echo $song->categorias_en;?></p>
                <?php else: ?>
                    <p class="caps"><span class="text-yellow">{%categories%}: </span><?php echo $song->categorias_es;?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(!empty($song->colaboradores)): ?>
                <p class="caps"><span class="text-yellow">{%collaborators%}: </span><?php echo $song->colaboradores;?></p>
            <?php endif; ?>
        </div>
        <div class="music__detail">
            <?php if(!empty($song->gensec_en)): ?>
                <?php if($lang == '_en'): ?>
                    <p class="caps"><span class="text-yellow">{%gensec%}: </span><?php echo $song->gensec_en;?></p>
                <?php else: ?>
                    <p class="caps"><span class="text-yellow">{%gensec%}: </span><?php echo $song->gensec_es;?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($lang == '_en'): ?>
                <p class="caps"><span class="text-yellow">{%languages%}: </span><?php echo $song->idioma_en;?></p>
            <?php else: ?>
                <p class="caps"><span class="text-yellow">{%languages%}: </span><?php echo $song->idioma_es;?></p>
            <?php endif; ?>


            <?php if(!empty($song->instrumentos_en)): ?>
                <?php if($lang == '_en'): ?>
                    <p class="caps"><span class="text-yellow">{%instruments%}: </span><?php echo $song->instrumentos_en;?></p>
                <?php else: ?>
                    <p class="caps"><span class="text-yellow">{%instruments%}: </span><?php echo $song->instrumentos_es;?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(!empty($song->keywords_en)): ?>
                <?php if($lang == '_en'): ?>
                    <p class="caps"><span class="text-yellow">{%keywords-title%}: </span><?php echo $song->keywords_en;?></p>
                <?php else: ?>
                    <p class="caps"><span class="text-yellow">{%keywords-title%}: </span><?php echo $song->keywords_es;?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(!empty($song->escritores)): ?>
                <p class="caps"><span class="text-yellow">{%writers%}: </span><?php echo $song->escritores;?></p>
            <?php endif; ?>

            <?php if(!empty($song->escritor_propiedad)): ?>
                <p class="caps"><span class="text-yellow">{%writers_property%}: </span><?php echo $song->escritor_propiedad;?></p>
            <?php endif; ?>

            <?php if(!empty($song->publisher_propiedad)): ?>
                <p class="caps"><span class="text-yellow">{%publishers_property%}: </span><?php echo $song->publisher_propiedad;?></p>
            <?php endif; ?>

            <?php if(!empty($song->sello_propiedad)): ?>
                <p class="caps"><span class="text-yellow">{%phonogram_property%}: </span><?php echo $song->sello_propiedad;?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($song->letra)): ?>
        <p class="capitalize-first-only"><span class="text-yellow">{%lyrics%}: </span><?php echo $song->letra;?></p>
    <?php endif; ?>
</div>

