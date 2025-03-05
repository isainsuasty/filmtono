<h1>{% music_singles_edit-title %}</h1>

<a href="/music/albums" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_singles-back_btn%}
</a>

<div class="form-div">
    <form class="form" method="POST">
        <?php
            include_once __DIR__.'/../../../templates/alertas.php';
        ?>
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" value="{%music_songs_edit-btn%}" class="btn-submit">
    </form>
</div>