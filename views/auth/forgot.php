<main class="container">
    <div class="auth">
        <h1>
            {%<?php echo $titulo;?>%}
        </h1>
        <p>{%auth_forgot-password_paragraph%}</p>

        <?php
            require_once __DIR__ . '/../templates/alertas.php';
        ?>

        <form method="POST" action="/forgot-password" class="form--max">
            <div class="form__group">
                <label for="email" class="form__group__label">{%auth_forgot-password_email_label%}</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form__group__input"
                    placeholder="{%auth_forgot-password_email_label%}"
                />
            </div>

            <input type="submit" value="{%auth_forgot-password_btn%}" class="btn-submit" />
        </form>

        <div class="acciones">
            <a href="/login" class="acciones__enlace">{%auth_register_already_account%}</a>
            <a href="/register" class="acciones__enlace">{%auth_login_not_account%}</a>  
        </div>
    </div>
</main>