<h1>{%keywords_main-title%}: <span class="text-green caps"><?php echo $categoria; ?></span></h1>

<a href="/filmtono/categories" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%categories_back-btn%}
</a>

<div class="dashboard__total">
    <p><span>{%keywords_total%}: </span>
        <!-- <?php //echo count($); ?> -->
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="keywords-search" placeholder="{%keywords_search-placeholder%}"/>
    </div>
</div>

<a href="/filmtono/categories/keywords/new?id=<?php echo $catId;?>" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {%keywords_new-btn%}
</a>

<div class="cards">
    <div class="cards__container" id="grid-keywords">
    </div>
</div>
