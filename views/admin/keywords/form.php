<fieldset class="form__fieldset">
    <div class="form__group">
        <label class="form__group__label" for="keyword_en">{%keywords_form-name-label-en%}</label>
        <input
            type="text"
            class="form__group__input"
            id="keyword_en"
            name="keyword_en"
            placeholder="{%keywords_form-name-placeholder-en%}"
            value="<?php echo s($keyword->keyword_en);?>"
            />
    </div>
    <div class="form__group">
        <label class="form__group__label" for="keyword_es">{%keywords_form-name-label-es%}</label>
        <input
            type="text"
            class="form__group__input"
            id="keyword_es"
            name="keyword_es"
            placeholder="{%keywords_form-name-placeholder-es%}"
            value="<?php echo s($keyword->keyword_es);?>"
            />
    </div>
</fieldset>