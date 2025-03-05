<div class="container">
    
     <h1>
        {% <?php echo $titulo;?> %}
    </h1>

    <p class="center">{%login_purchase-title%}</p>

    <?php if(isset($_SESSION['id'])): ?>
        
        <p class="auth__text">{%auth_already_registered%}</p>
        <div class="auth">
            <i class="auth__icon--fail fa-regular fa-circle-xmark"></i>
            <a class="btn-submit" href="<?php sesionActiva()?>">{%auth_back_admin_btn%}</a>
        </div>
    <?php else: ?>

    <div class="form-div">
        <form class="form" method="POST" action="/register" id="mesagge-form">
        <?php
            require_once __DIR__ . '/../templates/alertas.php';
        ?>
            <fieldset class="form__fieldset">
                <legend class="form__legend">{%music_albums_legend%}</legend>
                <input type="hidden" name="id_nivel" value="4">

                <div class="form__group">
                    <label class="form__group__label" for="nombre">
                        {%auth_register_name_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="nombre" id="nombre" placeholder="{%auth_register_name_label%}" value="<?php echo s($contacto->nombre); ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="apellido">
                        {%auth_register_lastname_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="apellido" id="apellido" placeholder="{%auth_register_lastname_label%}" value="<?php echo s($contacto->apellido); ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="email">
                        {%auth_register_email_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="email" name="email" id="email" placeholder="{%auth_register_email_label%}" value="<?php echo s($contacto->email); ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="pais">
                        {%auth_register_country_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="pais" id="pais" placeholder="{%auth_register_country_label%}" value="<?php echo s($contacto->pais); ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="telefono">
                        {%auth_register_phone_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <input class="form__group__input" type="text" name="telefono" id="telefono" placeholder="{%auth_register_phone_label%}" value="<?php echo s($contacto->telefono); ?>">
                </div>

                <div class="form__group">
                    <label class="form__group__label" for="presupuesto">{%auth_register_budget_label%}</label>
                    <input class="form__group__input" type="text" name="presupuesto" id="presupuesto" placeholder="{%auth_register_budget_placeholder%}" value="<?php echo s($contacto->presupuesto); ?>">
                </div>


                <div class="form__group">
                    <p class="texto--password">{%auth_register_message_paragraph%}</p>
                    <label class="form__group__label" for="mensaje">
                        {%auth_register_message_label%}
                        <span class="text-yellow">*</span>
                    </label>
                    <textarea class="form__group__textarea" name="mensaje" id="mensaje" placeholder="{%auth_register_message_placeholder%}"></textarea>
                </div>

                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <input class="btn-submit" type="submit" value="{%auth_register_message_btn%}">
            </fieldset>
        </form>
    </div>
    
    <?php endif; ?>
</div> 


<script src="https://www.google.com/recaptcha/api.js?render=6LdErd0pAAAAAH6zMR7aF0fP9CAZpZDWCC0EKpFU"></script>

<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LdErd0pAAAAAH6zMR7aF0fP9CAZpZDWCC0EKpFU', {action: 'submit'}).then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
    });
});
</script>