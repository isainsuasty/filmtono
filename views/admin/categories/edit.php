<h1>{%categories_edit-title%}</h1>

<a href="/filmtono/categories" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%categories_back-btn%}
</a>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST" enctype="multipart/form-data">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" id="btn-promo" value="{%categories_edit-submit-btn%}" class="btn-submit">
    </form>
</div>