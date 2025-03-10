<h1>{% music_singles_new-title %}</h1>

<a href="/music/albums" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_singles-back_btn%}
</a>

<div class="form-div">
    <?php if($tipoUsuario->id_nivel != 3):?>
        <p class="text-blue text-22 note-style mBottom-0">
        {%music_albums_artist_label_required%}
        </p>
        <div class="flex">
            <a href="/music/labels/new" class="btn-note">{%music_albums_goto-label-btn%}</a>
            <a href="/music/artists/new" class="btn-note">{%music_albums_goto-artist-btn%}</a>
        </div>
    <?php else:?>
        <p class="text-blue text-22 note-style mBottom-0">
            {%music_albums_artist_required%}
        </p>
        <a href="/music/artists/new" class="btn-note">{%music_albums_goto-artist-btn%}</a>
    <?php endif;?>
    <form class="form" method="POST">
        <?php
            include_once __DIR__.'/../../../templates/alertas.php';
        ?>
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" value="{%music_songs_new-btn%}" class="btn-submit">
    </form>
</div>