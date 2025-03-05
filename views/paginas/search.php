<div class="container">
    <h1>{%<?php echo $titulo; ?>%}</h1>
    <div class="filtros">
        <div class="filtros__search" id="search-songs-dashboard">
            <div class="filtros__search__input">
                <input class="filtros__search__input--search" type="text" id="songs-search" placeholder="{%t-search-songs_placeholder%}"/>
                <button class="btn-clear" id="clear-search">
                    <i class="fas fa-broom"></i>
                    {%clear-filters%}
                </button>
            </div>

            <div class="filtros__search__select">
                 <!--artistas-->
                 <div class="filtros__group">
                    <label class="filtros__group__label" for="artistas">{%t-search-songs_artist%}</label>
                    <select class="filtros__group__select" name="artistas" id="songs-artistas">
                        <option value="" selected disabled>
                            {%t-search-songs_artist_placeholder%}
                        </option>
                        <?php foreach ($artistas as $artista) { ?>
                            <option value="<?php echo $artista->id; ?>"><?php echo $artista->nombre; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!--generos-->
                <div class="filtros__group">
                    <label class="filtros__group__label" for="genero">{%t-search-songs_genre%}</label>
                    <select class="filtros__group__select" name="genero" id="songs-generos">
                        <option value="" selected disabled>
                            {%t-search-songs_genre_placeholder%}
                        </option>
                        <?php foreach ($generos as $genero) : ?>
                            <option value="<?php echo $genero->id; ?>">
                                <?php echo $lang =='en' ? $genero->genero_en : $genero->genero_es; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!--instrumentos-->
                <div class="filtros__group">
                    <label class="filtros__group__label" for="instrumento">{%t-search-songs-instrument%}</label>
                    <select class="filtros__group__select" name="instrumento" id="songs-instrumentos">
                        <option value="" selected disabled>
                            {%t-search-songs-instrument_placeholder%}
                        </option>
                        <?php foreach ($instrumentos as $instrumento) : ?>
                            <option value="<?php echo $instrumento->id; ?>">
                                <?php echo $lang =='en' ? $instrumento->keyword_en : $instrumento->keyword_es; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!--Idiomas-->
                <div class="filtros__group">
                    <label class="filtros__group__label" for="idioma">{%t-search-songs_language%}</label>
                    <select class="filtros__group__select" name="idioma" id="songs-idiomas">
                        <option value="" selected disabled>
                            {%t-search-songs_language_placeholder%}
                        </option>
                        <?php foreach ($idiomas as $idioma) : ?>
                            <option value="<?php echo $idioma->id; ?>">
                                <?php echo $lang =='en' ? $idioma->idioma_en : $idioma->idioma_es; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
              
                <!--Niveles de canción-->
                <div class="filtros__group">
                    <label class="filtros__group__label" for="nivel">{%t-search-songs_level%}</label>
                    <select class="filtros__group__select" name="nivel" id="songs-niveles">
                        <option value="" selected disabled>
                            {%t-search-songs_level_placeholder%}
                        </option>
                        <?php foreach ($niveles as $nivel) : ?>
                            <option value="<?php echo $nivel->id; ?>">
                                <?php echo $lang =='en' ? $nivel->nivel_en : $nivel->nivel_es; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                
                <!--Nivel Artista-->
                <div class="filtros__group">
                    <label class="filtros__group__label" for="artista-nivel">{%t-search-artist_level%}</label>
                    <select class="filtros__group__select" name="artista-nivel" id="songs-artista-nivel">
                        <option value="" selected disabled>
                            {%t-search-artist_level_placeholder%}
                        </option>
                        <?php foreach ($nivelArtistas as $artista) : ?>
                            <option value="<?php echo $artista->id; ?>">
                            <?php echo $lang =='en' ? $artista->nivel_en : $artista->nivel_es; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!--Categorias-->
                <div class="filtros__group">
                    <label class="filtros__group__label" for="categoria">{%t-search-songs_category%}</label>
                    <select class="filtros__group__select" name="categoria" id="songs-categorias">
                        <option value="" selected disabled>
                            {%t-search-songs_category_placeholder%}
                        </option>
                        <?php foreach ($categorias as $categoria) : ?>
                            <option value="<?php echo $categoria->id; ?>">
                                <?php echo $lang =='en' ? $categoria->categoria_en : $categoria->categoria_es; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Contenedor para el select customizado de subcategorías -->
                <div class="subcategories-wrapper" id="subcategories-wrapper">
                    <p>{%t-search-songs_subcategory%}</p>
                <!-- Aquí se inyectará el custom select de subcategorías cuando se seleccione una categoría -->
                </div>
                <input
                    type="hidden"
                    name="searchSongsSubcategory"
                    id="searchSongsSubcategory"
                    value=""
                />
            </div>
        </div>
    </div>

    <div class="cards__container" id="grid-songs-search">
    </div>
</div>