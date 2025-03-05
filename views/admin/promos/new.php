<h1>{% admin_promos_new-title %}</h1>

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
        <input type="submit" id="btn-promo" value="{%admin_promos_new-btn%}" class="btn-submit">
    </form>
</div>