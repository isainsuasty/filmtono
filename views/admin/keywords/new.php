<h1>{% keywords_new-title %}: <span class="text-green caps"><?php echo $category; ?></span></h1>

<a href="/filmtono/categories/keywords?id=<?php echo $catId.'&category='.$catName;?>" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%keywords_back-btn%}
</a>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST">
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" value="{%keywords_new-submit-btn%}" class="btn-submit">
    </form>
</div>