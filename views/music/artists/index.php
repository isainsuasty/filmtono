<h1>{%artists_main-title%}</h1>

<div class="dashboard__total">
    <p><span>{%artists_total%}: </span>
        <?php echo count($artistas); ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="artistas-search" placeholder="{%artists_search-placeholder%}"/>
    </div>
</div>

<a href="/music/artists/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {% artists_new-submit-btn %}
</a>

<div class="cards">
    <div class="cards__container" id="grid-artistas">
    </div>
</div>