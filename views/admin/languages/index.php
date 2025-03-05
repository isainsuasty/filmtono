<h1>{%languages_main-title%}</h1>

<div class="dashboard__total">
    <p><span>{%languages_total%}: </span>
        <?php echo $idiomas; ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="idiomas-search" placeholder="{%languages_search-placeholder%}"/>
    </div>
</div>

<a href="/filmtono/languages/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {%languages_new-title%}
</a>

<div class="cards">
    <div class="cards__container" id="grid-idiomas">
    </div>
</div>
