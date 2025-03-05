<h1>{%admin_genres_title%}</h1>

<a href="/filmtono/categories" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%categories_back-btn%}
</a>

<div class="dashboard__total">
    <p><span>{%admin_genres_total%}: </span>
        <?php echo count($generos); ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="generos-search" placeholder="{%admin_genres_search-placeholder%}"/>
    </div>
</div>

<a href="/filmtono/genres/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {%admin_genres_new-btn%}
</a>

<div class="cards">
    <div class="cards__container" id="grid-generos">
    </div>
</div>
