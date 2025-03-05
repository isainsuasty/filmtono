<h1>{% music_songs_add-title %}</h1>

<a href="/music/albums/current?id=<?php echo $album->id;?>" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_album-back_btn%}
</a>

<div class="form-div">
    <form class="form" method="POST">
    <?php
        include_once __DIR__.'/../../../templates/alertas.php';
        include_once __DIR__.'/form.php'
    ?>
        <input type="submit" value="{%music_songs_new-btn%}" class="btn-submit">
    </form>
</div>