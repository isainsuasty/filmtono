<h1>{%categories_main-title%}</h1>

<div class="dashboard__total">
    <p><span>{%categories_total%}: </span>
        <?php echo count($categorias); ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="categorias-search" placeholder="{%categories_search-placeholder%}"/>
    </div>
</div>

<a href="/filmtono/categories/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {%categories_new-btn%}
</a>

<div class="cards">
    <div class="cards__container" id="grid-categorias">
    </div>
</div>
