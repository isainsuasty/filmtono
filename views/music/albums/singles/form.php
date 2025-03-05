<fieldset class="form__fieldset">
    <legend class="form__legend">{%music_albums_legend%}</legend>
    <!--Sello discográfico-->
    <?php
    if($tipoUsuario->id_nivel != 3): ?>
        <div class="form__group">
            <label class="form__group__label" for="sello">
                {%music_albums_label_label%}
                <span class="text-yellow">*</span>
            </label>
            <select id="sello-song" name="sello" class="form__group__select">
                <option selected disabled value="">
                    {%music_albums_label_placeholder%}
                </option>
                <?php foreach($sellos as $sello): ?>
                    <option value="<?php echo s($sello->id); ?>"
                        <?php 
                            // Select the label if the record label is set (either from POST or from the song record)
                            echo (isset($_POST['sello']) && $_POST['sello'] == $sello->id) || (isset($cancionSello->id) && $cancionSello->id == $sello->id) ? 'selected' : '';
                        ?>>
                        <?php echo s($sello->nombre); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form__group--inline alert-style">
            <input class="form__group__input--checkbox" type="checkbox" id="noLabel" name="noLabel" 
                <?php 
                    // Logic for the checkbox:
                    // For new songs, it should not be checked by default unless user explicitly checks it.
                    // For editing, it will be checked if no label is selected.
                    if (isset($cancionSello) && empty($cancionSello->id)) {
                        // Song has no label assigned (editing)
                        echo 'checked';
                    } elseif (isset($_POST['noLabel']) && $_POST['noLabel'] == 'on') {
                        // User explicitly checked it (new or after form validation)
                        echo 'checked';
                    } elseif(!isset($cancionSello) && empty($cancionSello) && isset($edit) && !isset($_POST['sello'])) {
                        echo 'checked';
                    }else {
                        // For new songs, if no label is selected, don't check it by default
                        if (!isset($_POST['sello']) || $_POST['sello'] == '') {
                            echo '';  // Do not check by default for new songs without label
                        }
                    }
                ?>>
            <label for="noLabel" class="form__group__label" id="noLabelText">{%music_albums_no_label%}</label>
        </div>
    <?php endif; ?>


    
    <!--Título de la canción-->
    <div class="form__group">
        <label class="form__group__label" for="titulo">
            {%music_songs_form-title_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="text"
            class="form__group__input"
            id="titulo"
            name="titulo"
            placeholder="{%music_songs_form-title_placeholder%}"
            value="<?php echo !empty($song->titulo) ? s($song->titulo) : '';?>"/>
    </div>

    <!--Versión de la canción-->
    <div class="form__group">
        <label class="form__group__label" for="version">
            {%music_songs_form-version_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="text"
            class="form__group__input"
            id="version"
            name="version"
            placeholder="{%music_songs_form-version_placeholder%}"
            value="<?php echo !empty($song->version) ? s($song->version) : '';?>"/>
    </div>

    <!--URL Youtube-->
    <div class="form__group">
        <label class="form__group__label" for="url">
            {%music_songs_form-youtube_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="text"
            class="form__group__input"
            id="url"
            name="url"
            placeholder="{%music_songs_form-youtube_placeholder%}"
            value="<?php echo !empty($song->url) && !isset($edit) ? s(getYTVideoUrl($song->url)) : (isset($edit) && empty($_POST['url'])  ? getYTVideoUrl($song->url) : (!empty($_POST['url'])  ? $song->url : ''));?>"/>
    </div>

    <!--ISRC de la canción-->
    <div class="form__group">
        <label class="form__group__label" for="isrc">
            {%music_songs_form-isrc_label%}
            <span class="text-yellow">*</span>
        </label>
        <p class="texto--password">{%music_songs_form-isrc_help%}</p>
        <input
            type="text"
            class="form__group__input"
            id="isrc"
            name="isrc"
            placeholder="{%music_songs_form-isrc_placeholder%}"
            value="<?php echo !empty($song->isrc) ? s($song->isrc) : '';?>"/>
    </div>

    <!--Nivel de canción-->
    <div class="form__group">
        <label class="form__group__label" for="nivel">
            {%music_songs_form-song-level_label%}
            <span class="text-yellow">*</span>
        </label>
        <select class="form__group__select" name="nivel" id="nivel">
            <option selected disabled>
                {%music_songs_form-song-level_placeholder%}
            </option>
            <?php foreach($niveles as $nivel): ?>
                <option value="<?php echo $nivel->id; ?>"
                    <?php 
                        echo isset($_POST['nivel']) && $_POST['nivel'] == $nivel->id 
                            ? 'selected' 
                            : (isset($cancionNivel->id_nivel) && $cancionNivel->id_nivel == $nivel->id ? 'selected' : ''); 
                    ?>>
                    
                    <?php echo $lang =='en' ? $nivel->nivel_en : $nivel->nivel_es ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!--Artista principal-->
    <div class="form__group">
        <label class="form__group__label" for="artista">
            {%music_songs_form-artist_label%}
            <span class="text-yellow">*</span>
        </label>
        <select class="form__group__select" name="artista" id="artista-song">
            <?php if(isset($single)): ?>
                <option selected disabled>
                    {%music_songs_form-artist_placeholder%}
                </option>
                <?php foreach($artistas as $artista): ?>
                <option value="<?php echo s($artista->id); ?>"
                    <?php echo isset($_POST['artista']) && $_POST['artista'] == $artista->id ? 'selected' : (isset($cancionArtista->id_artista) && $cancionArtista->id_artista == $artista->id ? 'selected' : ''); ?>>
                    <?php echo $artista->nombre ?>
                </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="<?php echo s($artista->id); ?>" selected disabled><?php echo $artista->nombre ?></option>
            <?php endif; ?>
        </select>
    </div>

    <!--Colaboradores-->
    <div class="form__group">
        <label class="form__group__label" for="colaboradores">
            {%music_song_form-colaborators_label%}
        </label>
        <input
            type="text"
            class="form__group__input"
            id="colaboradores"
            name="colaboradores"
            placeholder="{%music_song_form-colaborators_placeholder%}"
            value="<?php echo !empty($songColab) ? s($songColab->colaboradores) : '';?>"/>
    </div>

    <!--Género principal-->
    <div class="form__group">
        <label class="form__group__label" for="genero">
            {%music_songs_form-genre_label%}
            <span class="text-yellow">*</span>
        </label>
        <select class="form__group__select" name="genero" id="genero">
            <option selected disabled>
                {%music_songs_form-genre_placeholder%}
            </option>

            <?php foreach($generos as $genero): ?>
                <option value="<?php echo $genero->id; ?>"
                    <?php
                        echo isset($_POST['genero']) && $_POST['genero'] == $genero->id ? 'selected' : (isset($cancionGenero->id_genero) && $cancionGenero->id_genero == $genero->id ? 'selected' : ''); ?>>
                    <?php echo $lang =='en' ? $genero->genero_en : $genero->genero_es ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Géneros secundarios-->
    <div class="form__group">
        <label class="form__group__label" for="generos">
            {%music_songs_form-subgenre_label%}
        </label>
        <select class="form__group__select" id="generos" multiple>
            <option disabled>
                {%music_songs_form-subgenre_placeholder%}
            </option>
            <?php 
            // Determine the selected genres
            $selectedGenres = isset($_POST['selectedGenres']) ? explode(',', $_POST['selectedGenres']) :
                // If not, check if we are editing and use the saved genres
                (!empty($selectedGenres) ? $selectedGenres : []);

            foreach ($generos as $genero): ?>
                <option 
                    value="<?php echo $genero->id; ?>" 
                    <?php echo in_array($genero->id, $selectedGenres) ? 'selected' : ''; ?>>
                    <?php echo $lang === 'en' ? $genero->genero_en : $genero->genero_es; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Tags for selected genres -->
        <div id="selectedGenres" class="form__group__languages">
            <?php foreach ($selectedGenres as $selectedGenreId): ?>
                <?php
                    $genreName = '';
                    foreach ($generos as $genero) {
                        if ($genero->id == $selectedGenreId) {
                            $genreName = $lang === 'en' ? $genero->genero_en : $genero->genero_es;
                        }
                    }
                ?>
                <span class="genero-tag" data-id="<?php echo $selectedGenreId; ?>">
                    <?php echo $genreName; ?>
                    <button type="button" class="remove-genero">&times;</button>
                </span>
            <?php endforeach; ?>
        </div>

        <!-- Hidden input to store selected genres -->
        <input 
            type="hidden" 
            id="selectedGenresInput" 
            name="selectedGenres" 
            value="<?php echo implode(',', $selectedGenres); ?>">
    </div>

    <!--Categorías-->
    <div class="section-bg">
        <div class="form__group">
            <label class="form__group__label" for="categorias">
                {%music_songs_form-categories_label%}
                <span class="text-yellow">*</span>
            </label>
            <p class="texto--password">{%music_songs-form-categories_help%}:</p>
            <select class="form__group__select" id="categorias">
                <option selected disabled>
                    {%music_songs_form-categories_placeholder%}
                </option>
                <?php 
                // Determine the selected categories
                // If it's a POST request, take values from the POST data
                $selectedSubcategories = isset($_POST['selectedSubcategories']) ? explode(',', $_POST['selectedSubcategories']) :
                    // If not, check if we are editing and use the saved categories
                    (!empty($selectedSubcategories) ? $selectedSubcategories : []);

                foreach ($categorias as $categoria): ?>
                    <option 
                        value="<?php echo $categoria->id; ?>" 
                        <?php echo in_array($categoria->id, $selectedSubcategories) ? 'selected' : ''; ?>>
                        <?php echo $lang === 'en' ? $categoria->categoria_en : $categoria->categoria_es; ?>
                    </option>
                <?php endforeach; ?>
            </select>


            <select class="form__group__select mTop-1" id="subcategorias" name="subcategorias" multiple>
                <option selected disabled>
                    {%music_songs_form-keywords_placeholder%}
                </option>
                <?php 
                // Determine the selected categories
                // If it's a POST request, take values from the POST data
                $selectedSubcategories = isset($_POST['selectedSubcategories']) ? explode(',', $_POST['selectedSubcategories']) :
                    // If not, check if we are editing and use the saved categories
                    (!empty($selectedSubcategories) ? $selectedSubcategories : []);

                    if(!empty($selectedSubcategories)){
                        foreach ($subcategorias as $subcategoria): ?>
                            <option 
                                value="<?php echo $subcategoria->id; ?>" 
                                <?php echo in_array($subcategoria->id, $selectedSubcategories) ? 'selected' : ''; ?>>
                                <?php echo $lang === 'en' ? $subcategoria->keyword_en : $subcategoria->keyword_es; ?>
                            </option>
                        <?php endforeach;
                    }
                    ?>
            </select>
        </div>
        <!-- Hidden input to store selected categories -->
        <input 
            type="hidden" 
            id="selectedSubcategoriesInput" 
            name="selectedSubcategories" 
            value="<?php echo implode(',', $selectedSubcategories); ?>"/>

             <!-- Tags for selected categories -->
            <div id="selectedSubcategories" class="form__group__languages">
                <?php foreach ($selectedSubcategories as $selectedSubcategoryId): ?>
                    <?php
                        $subcategoryName = '';
                        foreach ($subcategorias as $categoria) {
                            if ($categoria->id == $selectedCategoryId) {
                                $categoryName = $lang === 'en' ? $categoria->categoria_en : $categoria->categoria_es;
                            }
                        }
                ?>
                <span class="categoria-tag" data-id="<?php echo $selectedSubcategoryId; ?>">
                    <?php echo $categoryName; ?>
                    <button type="button" class="remove-subcategoria">&times;</button>
                </span>
                <?php endforeach; ?>
            </div>

            <!-- Hidden input to store selected categories -->
        <input 
            type="hidden" 
            id="selectedCategoriesInput" 
            name="selectedCategories" 
            value="<?php echo implode(',', $selectedCategories); ?>"/>
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


    <!--textarea for lyrics-->
    <div class="form__group">
        <label class="form__group__label">
            {%music_songs-form-lyrics_label%}
        </label>
        <textarea
            class="form__group__input"
            id="letra"
            name="letra"
            placeholder="{%music_songs-form-lyrics_placeholder%}"><?php 
            // Preserve the value
            echo isset($_POST['letra']) ? htmlspecialchars(trim($_POST['letra']), ENT_QUOTES, 'UTF-8') : (isset($cancionLetra->letra) ? htmlspecialchars(trim($cancionLetra->letra), ENT_QUOTES, 'UTF-8') : '');
            ?></textarea>
    </div>

    <!--Escritores-->
    <div class="form__group">
        <label class="form__group__label" for="escritores">
            {%music_songs_form-writers_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="text"
            class="form__group__input"
            id="escritores-song"
            name="escritores"
            placeholder="{%music_songs_form-writers_placeholder%}"
            value="<?php 
                echo isset($_POST['escritores']) 
                    ? htmlspecialchars(trim($_POST['escritores']), ENT_QUOTES, 'UTF-8') 
                    : (isset($cancionEscritores->escritores) 
                        ? htmlspecialchars(trim($cancionEscritores->escritores), ENT_QUOTES, 'UTF-8') 
                        : ''); 
            ?>"/>
    </div>

    <!--Publisher-->
    <div class="form__group">
        <label for="publisher" class="form__group__label">
            {%music_albums_publisher_label%}
            <span class="text-yellow">*</span>
        </label>
        <input
            type="text"
            class="form__group__input"
            id="publisher-song"
            name="publisher"
            placeholder="{%music_albums_publisher_placeholder%}"
            value= "<?php echo s($song->publisher);?>"
        />
    </div>

    <!--Porcentaje de escritor: publisher + escritores-->
    <h2 class="text-blue">{%music_songs_form-writers-percent_legend%}</h2>
    <p class="texto--password">{%music_songs_form-writers-percent_help%}:</p>
    <div class="form__group">
        <label class="form__group__label" for="escritor_propiedad">
            {%music_songs_form-writers-percent_label%}
            <span class="text-yellow">*</span>
        </label>
            <?php if(isset($_POST['escritores']) || isset($cancionEscritores->escritores)): ?>
                    <div class="form__group--info">
                        <p class="text-yellow mBottom-0 mTop-0">{%t-property-of%}: 
                            <span class="text-white caps" id="writers-property">
                                <?php 
                                if(isset($_POST['escritores'])):?>
                                    <?php echo $_POST['escritores'];?>
                                <?php elseif(isset($cancionEscritores->escritores)):?>
                                    <?php echo $cancionEscritores->escritores;?>
                                <?php endif;?>
                            </span>
                        </p>
                    </div>
            <?php endif;?>
        <input
            type="number"
            class="form__group__input"
            id="escritor_propiedad"
            name="escritor_propiedad"
            min="0"
            max="100"
            placeholder="{%music_songs_form-writers-percent_placeholder%}"
            value="<?php 
                echo isset($_POST['escritor_propiedad']) 
                    ? htmlspecialchars(trim($_POST['escritor_propiedad']), ENT_QUOTES, 'UTF-8') 
                    : (isset($cancionEscritorPropiedad->escritor_propiedad) 
                        ? htmlspecialchars(trim($cancionEscritorPropiedad->escritor_propiedad), ENT_QUOTES, 'UTF-8') 
                        : ''); 
            ?>"/>
    </div>

    <div class="form__group">
        <label class="form__group__label" for="publisher_propiedad">
            {%music_songs_form-publisher-percent_label%}
            <span class="text-yellow">*</span>
        </label>
            <?php if(isset($_POST['publisher']) || isset($song->publisher)): ?>
                    <div class="form__group--info">
                        <p class="text-yellow mBottom-0 mTop-0">{%t-property-of%}: 
                            <span class="text-white caps" id="publisher-property">
                                <?php 
                                if(isset($_POST['publisher'])):?>
                                    <?php echo $_POST['publisher'];?>
                                <?php elseif(isset($song->publisher)):?>
                                    <?php echo $song->publisher;?>
                                <?php endif;?>
                            </span>
                        </p>
                    </div>
            <?php endif;?>
        <input
            type="number"
            class="form__group__input"
            id="publisher_propiedad"
            name="publisher_propiedad"
            min="0"
            max="100"
            placeholder="{%music_songs_form-publisher-percent_placeholder%}"
            value="<?php 
                echo isset($_POST['publisher_propiedad']) 
                    ? htmlspecialchars(trim($_POST['publisher_propiedad']), ENT_QUOTES, 'UTF-8') 
                    : (isset($cancionEscritorPropiedad->publisher_propiedad) 
                        ? htmlspecialchars(trim($cancionEscritorPropiedad->publisher_propiedad), ENT_QUOTES, 'UTF-8') 
                        : ''); 
            ?>"/>
    </div>

    <!--Porcentaje de fonograma-->
    <h2 class="text-blue">{%music_songs-form-phonogram-percent_legend%}</h2>
    <p class="texto--password">{%music_songs-form-phonogram-percent_help%}:</p>

    <div class="form__group">
        <label class="form__group__label" for="sello_propiedad">
            {%music_songs-form-phonogram-percent_label%}
            <span class="text-yellow">*</span>
        </label>    

            <?php if(isset($_POST['label']) || isset($song->sello) || isset($_POST['artista']) || isset($song->artista)): ?>
                    <div class="form__group--info">
                        <p class="text-yellow mBottom-0 mTop-0">{%t-property-of%}: 
                            <span class="caps text-white" id="phonogram-property">
                                <?php 
                                if(isset($_POST['sello']) || isset($_POST['artista']) ){
                                    echo $temporarySello.' + '. $temporaryArtista;
                                }elseif(isset($song->sello)){
                                    echo $song->sello;
                                    if(isset($artistaEdit)){
                                        echo ' + '.$artistaEdit;
                                    }
                                }?>
                            </span>
                        </p>
                    </div>
            <?php endif;?>
        <input
            type="number"
            class="form__group__input"
            id="sello_propiedad"
            name="sello_propiedad"
            min="0"
            max="100"
            placeholder="{%music_songs-form-phonogram_placeholder%}"
            value="<?php 
                echo isset($_POST['sello_propiedad']) 
                    ? htmlspecialchars(trim($_POST['sello_propiedad']), ENT_QUOTES, 'UTF-8') 
                    : (isset($cancionSelloPropiedad->sello_propiedad) 
                        ? htmlspecialchars(trim($cancionSelloPropiedad->sello_propiedad), ENT_QUOTES, 'UTF-8') 
                        : ''); 
            ?>"/>
    </div>
</fieldset>
