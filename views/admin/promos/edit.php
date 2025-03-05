<h1>{% admin_promos_edit-title %}</h1>

<a href="/filmtono/promos" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%admin_promos_btn-back%}
</a>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST" enctype="multipart/form-data">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" id="btn-artista" value="{%admin_promos_edit-btn%}" class="btn-submit">
    </form>
</div>