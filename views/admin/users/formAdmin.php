<div class="form__group">
    <label class="form__group__label" for="nombre">{%auth_register_name_label%}</label>
    <input class="form__group__input" type="text" name="nombre" id="nombre" placeholder="{%auth_register_name_label%}" value="<?php echo s($usuario->nombre); ?>">
</div>

<div class="form__group">
    <label class="form__group__label" for="apellido">{%auth_register_lastname_label%}</label>
    <input class="form__group__input" type="text" name="apellido" id="apellido" placeholder="{%auth_register_lastname_label%}" value="<?php echo s($usuario->apellido); ?>">
</div>

<div class="form__group">
    <label class="form__group__label" for="email">{%auth_register_email_label%}</label>
    <input class="form__group__input" type="email" name="email" id="email" placeholder="{%auth_register_email_label%}" value="<?php echo s($usuario->email); ?>">
</div>

<p class="texto--password">{%auth_alert_password-weak%}</p>

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