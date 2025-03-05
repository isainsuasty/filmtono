<div class="container">
    <h1>{%<?php echo $titulo; ?>%}</h1>

    <p class="center">{%contact_text-1%}</p>

    <div class="form-div">
        <form class="form" method="POST" action="/contact" id="mesagge-form">
        <?php
            require_once __DIR__ . '/../templates/alertas.php';
        ?>
            <fieldset class="form__fieldset">
                <legend class="form__legend">{%music_albums_legend%}</legend>
                <div class="form__group">
                    <label class="form__group__label" for="nombre">
                        {%auth_register_name_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="nombre" id="nombre" placeholder="{%auth_register_name_label%}" value="<?php echo !empty($contacto->nombre) ? s($contacto->nombre) : ''; ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="apellido">
                        {%auth_register_lastname_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="apellido" id="apellido" placeholder="{%auth_register_lastname_label%}" value="<?php echo !empty($contacto->apellido) ? s($contacto->apellido) : ''; ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="email">
                        {%auth_register_email_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="email" name="email" id="email" placeholder="{%auth_register_email_label%}" value="<?php echo !empty($contacto->email) ? s($contacto->email) : ''; ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="pais">
                        {%auth_register_country_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="pais" id="pais" placeholder="{%auth_register_country_label%}" value="<?php echo !empty($contacto->pais) ? s($contacto->pais) : ''; ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="telefono">
                        {%auth_register_phone_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="telefono" id="telefono" placeholder="{%auth_register_phone_label%}" value="<?php echo !empty($contacto->telefono) ? s($contacto->telefono) : ''; ?>">
                </div>

                <div class="form__group">
                    <p class="texto--password">{%auth_register_message_paragraph%}</p>
                    <label class="form__group__label" for="mensaje">
                        {%auth_register_message_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <textarea class="form__group__textarea" name="mensaje" id="mensaje" placeholder="{%auth_register_message_placeholder%}"><?php echo isset($_POST['mensaje']) ? s(trim($_POST['mensaje']), ENT_QUOTES, 'UTF-8') : (isset($contacto->mensaje) ? s(trim($contacto->mensaje), ENT_QUOTES, 'UTF-8'): trim(''));?></textarea>
                </div>

                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <input class="btn-submit" type="submit" value="{%auth_register_message_btn%}">
            </fieldset>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6LdErd0pAAAAAH6zMR7aF0fP9CAZpZDWCC0EKpFU"></script>

<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LdErd0pAAAAAH6zMR7aF0fP9CAZpZDWCC0EKpFU', {action: 'submit'}).then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
    });
});
</script>