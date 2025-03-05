<h1>{%users_main_title%}</h1>

<div class="dashboard__total">
    <p><span>{%users_total%}: </span>
        <?php echo count($usuarios); ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="usuario-search" placeholder="{%users_search-placeholder%}"/>
    </div>
</div>

<a href="/filmtono/users/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {%users_add-btn%}
</a>

<div class="cards">
    <div class="cards__container" id="grid-usuarios">
    </div>
</div>