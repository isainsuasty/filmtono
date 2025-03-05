<legend class="form__legend">{% profile_form_edit-profile %}</legend>
<div class="form__group">
    <label class="form__group__label" for="nombre">{% profile_form_name_label %}</label>
    <input class="form__group__input" type="text" name="nombre" value="<?php echo $usuario->nombre?>" id="nombre" placeholder="{%profile_form_name_placeholder%}">
</div>

<div class="form__group">
    <label class="form__group__label" for="apellido">{%profile_form_last_name_label%}</label>
    <input class="form__group__input" type="text" name="apellido" value="<?php echo $usuario->apellido?>" id="apellido" placeholder="{%profile_form_last_name_placeholder%}">
</div>

<div class="form__group">
    <label class="form__group__label" for="email">{%profile_form_email_label%}</label>
    <input disabled class="form__group__input" type="email" name="email" id="email" value="<?php echo $usuario->email?>" placeholder="{%profile_form_email_placeholder%}">
</div>

<legend class="form__legend">{%profile_form_edit-password%}</legend>
<div class="form__group">
    <label class="form__group__label" for="password">{%profile_form_new-password_label%}</label>
    <input class="form__group__input" type="password" name="password" id="password" placeholder="{%profile_form_new-password_placeholder%}">
    <i class="fa fa-eye passview"></i>
</div>

<div class="form__group">
    <label class="form__group__label" for="password2">{%profile_form_new-password_confirmation_label%}</label>
    <input class="form__group__input" type="password" name="password2" id="password2" placeholder="{%profile_form_new-password_confirmation_placeholder%}">
    <i class="fa fa-eye passview"></i>
</div>


<div class="acciones">
    <input class="btn-submit" type="submit" value="{%profile_form_save-btn%}">
    <button id="eliminar-cuenta" class="btn-delete" data-role="music" data-item="profile" value="<?php echo $usuario->id;?>">
        <i class="fa-solid fa-trash-can no-click"></i>
        {%profile_form_delete-btn%}
    </button>
</div>