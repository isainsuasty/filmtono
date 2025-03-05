<fieldset class="form__fieldset">
    <div class="form__group">
        <label class="form__group__label" for="genero_en">{%admin_genres_form-name_english_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="genero_en"
            name="genero_en"
            placeholder="{%admin_genres_form-name_english_placeholder%}"
            value="<?php echo s($genero->genero_en);?>"
            />
    </div>
    <div class="form__group">
        <label class="form__group__label" for="genero_es">{%admin_genres_form-name_spanish_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="genero_es"
            name="genero_es"
            placeholder="{%admin_genres_form-name_spanish_placeholder%}"
            value="<?php echo s($genero->genero_es);?>"
            />
    </div>
</fieldset>