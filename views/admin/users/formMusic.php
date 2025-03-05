<div class="form__group">
    <label class="form__group__label" for="tipo">{%auth_register-music_user_type_label%}</label>
    <select class="form__group__select" name="id_musica" id="tipo">
        <option selected disabled>
            {%auth_register_select_default%}
        </option>
        <?php foreach($musico as $tipo): ?>
            <option value="<?php echo $tipo->id; ?>"><?php echo $lang =='en' ? $tipo->tipo_en : $tipo->tipo_es ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form__group">
    <label class="form__group__label" for="nombre">{%auth_register-music_name_label%}</label>
    <input class="form__group__input" type="text" name="nombre" id="nombre" placeholder="{%auth_register-music_name_label%}" value="<?php echo s($usuario->nombre); ?>">
</div>

<div class="form__group">
    <label class="form__group__label" for="apellido">{%auth_register-music_lastname_label%}</label>
    <input class="form__group__input" type="text" name="apellido" id="apellido" placeholder="{%auth_register-music_lastname_label%}" value="<?php echo s($usuario->apellido); ?>">
</div>

<div class="form__group">
    <label class="form__group__label" for="email">{%auth_register-music_email_label%}</label>
    <input class="form__group__input" type="email" name="email" id="email" placeholder="{%auth_register-music_email_label%}" value="<?php echo s($usuario->email); ?>">
</div>

<p class="texto--password">{%auth_alert_password-weak%}</p>

<div class="form__group">
    <label class="form__group__label" for="password">{%auth_register-music_password_label%}</label>
    <input class="form__group__input" type="password" name="password" class="password" placeholder="{%auth_register-music_password_label%}">
    <i class="fa fa-eye passview"></i>
</div>

<div class="form__group">
    <label class="form__group__label" for="password2">{%auth_register-music_password_confirmation_label%}</label>
    <input class="form__group__input" type="password" name="password2" id="password2" placeholder="{%auth_register-music_password_confirmation_label%}">
    <i class="fa fa-eye passview"></i>
</div>