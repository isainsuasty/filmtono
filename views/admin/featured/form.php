<fieldset class="form__fieldset">
<!--imagen o video-->
    <div class="form__group">
        <label class="form__group__label">{%admin_featured_form-title_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="title"
            name="title"
            placeholder="{%admin_featured_form-title_placeholder%}"
            value="<?php echo s($featured->title);?>"
        />
    </div>
    <div class="form__group">
        <label class="form__group__label">{%admin_featured_form-url_label%}</label>
        <input
            type="text"
            class="form__group__input"
            id="videoId"
            name="videoId"
            placeholder="{%admin_featured_form-url_placeholder%}"
            value="<?php echo !empty($featured->videoId) && !isset($edit) ? s(getYTVideoUrl($featured->videoId)) : (isset($edit) && empty($_POST['videoId'])  ? getYTVideoUrl($featured->videoId) : (!empty($_POST['videoId'])  ? $featured->videoId : ''));?>"
        />
    </div>
</fieldset>
