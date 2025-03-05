<h1>{% music_albums_edit-title %}</h1>

<a href="/music/albums" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_album-back_btn%}
</a>

<div class="form-div">
    <form class="form" method="POST" enctype="multipart/form-data">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" id="btn-artista" value="{%music_albums_edit-btn%}" class="btn-submit">
    </form>
</div>