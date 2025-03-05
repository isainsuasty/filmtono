<fieldset class="form__fieldset">
<!--imagen o video-->
    <div class="form__group">
        <label class="form__group__label">{%admin_promos_new-title%}</label>
        <input
            type="file"
            class="form__custom__input"
            id="promos"
            name="promos"
            accept="video/*, image/png, image/jpeg, image/webp, image/avif"
            placeholder="{%music_albums_cover_placeholder%}"
            value="<?php echo s($promo->archivo);?>"
        />
        <!-- if file is selected, show the file name -->
        <span class="form__custom__file-name" id="promoLabel"></span>
    </div>
</fieldset>
