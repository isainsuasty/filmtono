<fieldset class="form__fieldset">
    <legend class="form__legend">{%music_albums_legend%}</legend>

<!--imagen de portada-->
    <div class="form__group">
        <label for="portada" class="form__group__label">
            {%music_albums_cover_label%}
        </label>
        <p class="texto--password">{%music_albums_cover_help%}</p>
        <input
            type="file"
            class="form__custom__input"
            id="imageFile"
            name="portada"
            placeholder="{%music_albums_cover_placeholder%}"
            accept="image/png, image/jpeg, image/jpg, image/webp"
            data-text="{%music_albums_cover_placeholder%}"
        />
        <?php if($album->portada):?>
            <div class="form__group__image">
                <img class="cards__img cards__img--album mTop-1" src="/portadas/<?php echo $album->portada; ?>" alt="<?php echo $album->titulo; ?>" loading="lazy">
            </div>
        <?php endif;?>
    </div>

    <!--Título-->
    <div class="form__group">
        <label for="titulo" class="form__group__label">
            {%music_albums_title_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="text"
            class="form__group__input"
            id="titulo"
            name="titulo"
            placeholder="{%music_albums_title_placeholder%}"
            value="<?php echo s($album->titulo);?>"
            />
    </div>

    <!--UPC-->
    <div class="form__group">
        <label for='upc' class="form__group__label">
            {%music_albums_upc_label%}
            <span class="text-yellow">*</span>
        </label>
        <p class="texto--password">{%music_albums_upc_help%}</p>
        <input
            type="text"
            class="form__group__input"
            id="upc"
            name="upc"
            placeholder="{%music_albums_upc_placeholder%}"
            value="<?php echo s($album->upc);?>"
            />
    </div>

    <!--Artista principal-->
    <div class="form__group">
        <label for="artistas" class="form__group__label">
            {%music_albums_artist_label%}
            <span class="text-yellow">*</span>
        </label>
        <select id="artistas" name="artistas" class="form__group__select">
            <option selected disabled value="">{%music_albums_artist_placeholder%}</option>
            <?php foreach($artistas as $artista): ?>
                <option value="<?php echo s($artista->id); ?>" <?php echo ($artista->id === $selectedArtistId) ? 'selected' : ''; ?>>
                    <?php echo s($artista->nombre); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!--Artistas secundarios-->
    <div class="form__group">
        <label class="form__group__label">{%music_albums_artist-secondary_label%}</label>
        <input
            type="text"
            list="artistas"
            name="art-secundarios"
            id="art-secundarios"
            class="form__group__input artistas_input"
            placeholder="{%music_albums_artist-secondary_placeholder%}"
            value="<?php echo isset($albumArtSecundarios)? ($albumArtSecundarios->artistas) : '';?>"
        />
    </div>

    <!--Idiomas-->
    <div class="form__group">
        <label for="idiomas" class="form__group__label">
            {%music_albums_languages_label%}
            <span class="text-yellow">*</span>
        </label>
        <select id="idiomas" name="idiomas" class="form__group__select" multiple>
            <option disabled value="">{%music_albums_languages_placeholder%}</option>

            <?php 
            // Retrieve previously selected languages
            $selectedLanguages = isset($_POST['selectedLanguages']) ? explode(',', $_POST['selectedLanguages']) :
                // If not, check if we are editing and use the saved languages
                (!empty($selectedLanguages) ? $selectedLanguages : []);

            foreach ($idiomas as $idioma): ?>
                <option 
                    value="<?php echo $idioma->id; ?>"
                    <?php echo in_array($idioma->id, $selectedLanguages) ? 'selected' : ''; ?>>
                    <?php echo ($lang === 'en') ? $idioma->idioma_en : $idioma->idioma_es; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Container to display the selected languages as tags -->
        <div id="selectedLanguages" class="form__group__languages">
            <?php foreach ($selectedLanguages as $selectedLanguageId): ?>
                <?php 
                // Get the language name based on the ID
                $languageName = '';
                foreach ($idiomas as $idioma) {
                    if ($idioma->id == $selectedLanguageId) {
                        $languageName = ($lang === 'en') ? $idioma->idioma_en : $idioma->idioma_es;
                        break;
                    }
                }
                ?>
                <span class="language-tag" data-id="<?php echo $selectedLanguageId; ?>">
                    <?php echo $languageName; ?> <button type="button" class="remove-language">&times;</button>
                </span>
            <?php endforeach; ?>
        </div>

        <!-- Hidden input to hold the selected language IDs -->
        <input type="hidden" id="selectedLanguagesInput" name="selectedLanguages" value="<?php echo implode(',', $selectedLanguages); ?>">
    </div>

    <!--Sello discográfico-->
    <?php
        if($tipoUsuario->id_nivel != 3):?>
            <div class="form__group">
                <label class="form__group__label" for="sello">
                    {%music_albums_label_label%}
                    <span class="text-yellow">*</span>
                </label>
                <select id="sello" name="sello" class="form__group__select">
                    <option selected disabled value="">
                        {%music_albums_label_placeholder%}
                    </option>
                    <?php foreach($sellos as $sello): ?>
                        <option value="<?php echo s($sello->id); ?>"
                            <?php
                                echo isset($_POST['sello']) && $_POST['sello'] == $sello->id ? 'selected'
                                : (isset($albumSello->id) && $albumSello->id == $sello->id ? 'selected' :
                                ''); 
                            ?>>
                            <?php echo s($sello->nombre); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form__group--inline alert-style">
                <input class="form__group__input--checkbox" type="checkbox" id="noLabel" name="noLabel">
                <label for="noLabel" class="form__group__label">{%music_albums_no_label%}</label>
            </div>
    <?php endif;
    ?>

    <input type="hidden" id="defaultLabel" name="defaultLabel" value="No label">

    <!--Fecha de lanzamiento-->
    <div class="form__group">
        <label for="fecha_rec" class="form__group__label">
            {%music_albums_record_date_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="date"
            class="form__group__input"
            id="fecha_rec"
            name="fecha_rec"
            placeholder="{%music_albums_record_date_placeholder%}"
            value="<?php echo s($album->fecha_rec);?>"
        />
    </div>
</fieldset>
