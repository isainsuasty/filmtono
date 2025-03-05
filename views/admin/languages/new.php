<h1>{%languages_new-title%}</h1>

<a href="/filmtono/languages" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%languages_back-btn%}
</a>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST" enctype="multipart/form-data">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" id="btn-promo" value="{%languages_new-btn%}" class="btn-submit">
    </form>
</div>