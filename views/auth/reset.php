<main class="auth container">
    <h1 class="auth__heading">{%<?php echo $titulo; ?>%}</h1>
    

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if($token_valido){ ?>
        <p>{%auth_reset-password_paragraph%}</p>
        <form method="POST" class="form--max">
            <div class="form__group">
                <label class="form__group__label" for="password">{%auth_register_password_label%}</label>
                <input class="form__group__input" type="password" name="password" id="password" placeholder="{%auth_register_password_label%}">
                <i class="fa fa-eye passview"></i>
            </div>

            <div class="form__group">
                <label class="form__group__label" for="password2">{%auth_register_password_confirmation_label%}</label>
                <input class="form__group__input" type="password" name="password2" id="password2" placeholder="{%auth_register_password_confirmation_label%}">
                <i class="fa fa-eye passview"></i>
            </div>

            <input type="submit" value="{%auth_reset-password_btn%}" class="btn-submit" />
        </form>
    <?php } ?>
    <div class="acciones">
        <a href="/login" class="acciones__enlace">{%auth_register_already_account%}</a>
        <a href="/register" class="acciones__enlace">{%auth_login_not_account%}</a>        
    </div>
</main>