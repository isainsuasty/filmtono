<fieldset class="form__fieldset">
    <div class="form__group">
        <label class="form__group__label">{%music_labels_form-name_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="nombre"
            name="nombre"
            placeholder="{%music_labels_form-name_placeholder%}"
            value="<?php echo s($sellos->nombre);?>"/>
    </div>
</fieldset>
