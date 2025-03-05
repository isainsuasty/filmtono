<div class="tabs__music">
    <div class="tabs__music__buttons">
        <button class="tabs__music__buttons--btn tabs__music__buttons--btn--active" id="btn-albums">{% music_tab_albums %}</button>
        <button class="tabs__music__buttons--btn" id="btn-singles">{% music_tab_singles %}</button>
    </div>
    <div class="tabs__music--albums">
        <h1>{% music_albums-title %}</h1>
        <div class="dashboard__total">
            <p>
                <span>{% music_albums-total %}:</span>
                <?php echo count($albums) ?>
            </p>

            <div class="dashboard__search">
                <input class="dashboard__total__type-search" type="text" id="albumes-search" placeholder="{% music_albums_search-placeholder %}"/>
            </div>
        </div>

        <div class="cards__container mTop-5" id="grid-albumes">
        </div>
    </div>

    <!--Section of singles-->
    <div class="tabs__music--singles tabs__music--disabled">
        <h1>{% music_singles_title %}</h1>
        <div class="dashboard__total">
            <p>
                <span>{% music_singles_total %}:</span>
                <?php echo count($singles) ?>
            </p>   

            <div class="dashboard__search">
                <input class="dashboard__total__type-search" type="text" id="singles-search" placeholder="{% music_singles_search-placeholder %}"/>
            </div>
        </div>

        <h3 class="dashboard__subtitle--filter"></h3>
        <?php if (isset($singles) && !empty($singles)): ?>
            <div class="cards__container" id="grid-singles">
            </div>
        <?php else: ?>
            <p>{% music_singles-empty %}</p>
        <?php endif ?>
    </div>
</div>