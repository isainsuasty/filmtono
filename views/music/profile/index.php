<h1>{% <?php echo $titulo;?> %}</h1>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div">   
    <form class="form" method="POST">
        <?php include_once __DIR__.'/form.php'?>
    </form>
</div>