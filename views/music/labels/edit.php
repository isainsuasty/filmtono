<h1>{% <?php echo $titulo;?> %}</h1>

<a href="/music/labels" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%music_labels-back_btn%}
</a>

<?php
    include_once __DIR__.'/../../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST">
        <legend class="form__legend">{%music_labels_edit-legend%}</legend>
        <?php include_once __DIR__.'/form.php'?>
        <input type="submit" value="{%music_labels_edit-submit_btn%}" class="btn-submit">
    </form>
</div>
