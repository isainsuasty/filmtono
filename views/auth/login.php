<main class="container">
    <h1>
        {% <?php echo $titulo;?> %}
    </h1>

    <?php if(isset($_SESSION['id'])): ?>        
        <p class="auth__text">{%auth_already_logged%}</p>
        <div class="auth">
            <i class="auth__icon--fail fa-regular fa-circle-xmark"></i>
            <a class="btn-submit" href="<?php sesionActiva()?>">{%auth_back_admin_btn%}</a>
        </div>
    <?php else: ?>

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <div class="form-div">
        <form class="form" method="POST" action="/login">
            <div class="form__group">
                <label class="form__group__label" for="email">{%auth_login_email_label%}</label>
                <input class="form__group__input" type="email" name="email" id="email" placeholder="Tu email" value="<?php echo ($usuario)? s($usuario->email): '';?>">
            </div>

            <div class="form__group">
                <label class="form__group__label" for="password">{%auth_login_password_label%}</label>
                <input class="form__group__input" type="password" name="password" id="password" placeholder="Tu password">
                <i class="fa fa-eye passview"></i>
            </div>

            <input class="btn-submit" type="submit" value="{%auth_login_btn%}">
        </form>
    </div>

    <div class="acciones">
        <a href="/register" class="acciones__enlace">{%auth_login_not_account%}</a><a href="/forgot-password" class="acciones__enlace">{%auth_login_forgot_password%}</a>
    </div>
    
    <?php endif; ?>
</main>