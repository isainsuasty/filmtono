<h1>{%users_new_title%}</h1>

<a href="/filmtono/users" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%users_back-btn%}
</a>

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="form-div tabs__lg">
    <div class="tabs__lg__buttons">
        <button class="tabs__lg--btn tabs__lg--btn--active" id="btn-admin">{%users_create_admin-title%}</button>
        <button class="tabs__lg--btn" id="btn-musica">{%users_create_music-title%}</button>
    </div>

    <form class="form tabs__lg--tab" method="POST">
        <?php include_once __DIR__.'/formAdmin.php'?>
        <input type="submit" id="btn-user-admin" value="{%users_add-btn%}" class="btn-submit">
    </form>

    <form class="form tabs__lg--tab tabs__lg--disabled" method="POST">
        <?php include_once __DIR__.'/formMusic.php'?>
        <input type="submit" id="btn-user-music" value="{%users_add-btn%}" class="btn-submit">
    </form>
</div>