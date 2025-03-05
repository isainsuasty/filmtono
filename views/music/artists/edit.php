<h1>{% <?php echo $titulo;?> %}</h1>

<a href="/music/artists" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%artists_back-btn%}
</a>

<?php
    include_once __DIR__.'/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form form-artist" method="POST">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" value="{%artists_edit-submit-btn%}" class="btn-submit">
    </form>
</div>
