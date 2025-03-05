
<h1>{%t-profile%}</h1>

<?php
    require_once __DIR__ . '/../templates/alertas.php';
?>

<div class="form-div">
    <form class="form" method="POST">
    <legend class="form__legend">Editar tu perfil</legend>
        <div class="form__group">
            <label class="form__group__label" for="nombre">Nombre</label>
            <input class="form__group__input" type="text" name="nombre" value="<?php echo $usuario->nombre?>" id="nombre" placeholder="Tu nombre">
        </div>

        <div class="form__group">
            <label class="form__group__label" for="nombre">Apellido</label>
            <input class="form__group__input" type="text" name="apellido" value="<?php echo $usuario->apellido?>" id="apellido" placeholder="Tu apellido">
        </div>

        <div class="form__group">
            <label class="form__group__label" for="email">Email</label>
            <input disabled class="form__group__input" type="email" name="email" id="email" value="<?php echo $usuario->email?>" placeholder="Tu email">
        </div>

        <legend class="form__legend">Cambia tu password</legend>
        <div class="form__group">
            <label class="form__group__label" for="password">Nuevo Password</label>
            <input class="form__group__input" type="password" name="password" id="password" placeholder="Tu password">
        </div>

        <div class="form__group">
            <label class="form__group__label" for="password2">Repetir tu Password</label>
            <input class="form__group__input" type="password" name="password2" id="password2" placeholder="Repite el password">
        </div>

        
        <div class="acciones">
            <input class="btn-submit" type="submit" value="Actualizar cuenta">
            <button id="eliminar-cuenta" class="btn-delete" data-rol="filmtono" data-item="profile" value="<?php echo $usuario->id;?>">
                <i class="fa-solid fa-trash-can no-click"></i>
                Eliminar Cuenta
            </button>
        </div>
    </form>
</div>