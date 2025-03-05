<fieldset class="form__fieldset">
    <div class="form__group">
        <label class="form__group__label" for="nombre">{%artists_form_name_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="nombre"
            name="nombre"
            placeholder="{%artists_form_name_placeholder%}"
            value="<?php echo s($artista->nombre);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="precio_show">{%artists_form_show-price_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="precio_show"
            name="precio_show""
            placeholder="{%artists_form_show-price_placeholder%}"
            value="<?php echo s($artista->precio_show);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="id_nivel">{%artists_form-level_label%}</label>
        <select
            class="form__group__select"
            id="id_nivel"
            name="id_nivel">
            <option value="">{%artists_form-level_placeholder%}</option>
            <?php foreach($niveles as $nivel): ?>
                <option
                    value="<?php echo $nivel->id;?>"
                    <?php echo $artista->id_nivel === $nivel->id ? 'selected' : ''; ?>>
                    <?php echo ($lang =='en') ? $nivel->nivel_en : $nivel->nivel_es ;?>
                </option>
            <?php endforeach; ?>
        </select>
    <div class="form__group">
        <label class="form__group__label" for="instagram">{%artists_form_instagram_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="instagram"
            name="instagram""
            placeholder="{%artists_form_instagram_placeholder%}"
            value="<?php echo s($artista->instagram);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="facebook">{%artists_form_facebook_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="facebook"
            name="facebook"
            placeholder="{%artists_form_facebook_placeholder%}"
            value="<?php echo s($artista->facebook);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="twitter">{%artists_form_twitter_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="twitter"
            name="twitter"
            placeholder="{%artists_form_twitter_placeholder%}"
            value="<?php echo s($artista->twitter);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="youtube">{%artists_form_youtube_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="youtube"
            name="youtube"
            placeholder="{%artists_form_youtube_placeholder%}"
            value="<?php echo s($artista->youtube);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="spotify">{%artists_form_spotify_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="spotify"
            name="spotify"
            placeholder="{%artists_form_spotify_placeholder%}"
            value="<?php echo s($artista->spotify);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="tiktok">{%artists_form_tiktok_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="tiktok"
            name="tiktok"
            placeholder="{%artists_form_tiktok_placeholder%}"
            value="<?php echo s($artista->tiktok);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="website">{%artists_form_website_label%}</label>
        <input
            type="text"
            class="form__group__input url"
            id="website"
            name="website"
            placeholder="{%artists_form_website_placeholder%}"
            value="<?php echo s($artista->website);?>"/>
    </div>
    <div class="form__group">
        <label class="form__group__label" for="banner">{%artists_form_banner_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="banner"
            name="banner"
            placeholder="{%artists_form_banner_placeholder%}"
            value="<?php echo s($artista->banner);?>"/>
    </div>
</fieldset>