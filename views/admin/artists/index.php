<h1>{%index_subtitle-artists%}</h1>

<div class="dashboard__total">
    <p><span>{%artists_total%}: </span>
        <?php echo count($artistas); ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="artistas-search" placeholder="{%artists_search-placeholder%}"/>
    </div>
</div>

<div class="cards">
    <div class="cards__container" id="grid-artistas">
    </div>
</div>