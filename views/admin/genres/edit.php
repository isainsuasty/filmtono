<h1>{% admin_genres_edit-title %}</h1>

<a href="/filmtono/genres" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%admin_genres_back-btn%}
</a>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" value="{%admin_genres_edit-btn%}" class="btn-submit">
    </form>
</div>