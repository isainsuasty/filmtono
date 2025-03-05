<h1>{%messages_title%}</h1>

<div class="dashboard__total">
    <p><span>{%messages_total%}: </span>
        <?php echo count($mensajes); ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="mensajes-search" placeholder="{%messages_search-placeholder%}"/>
    </div>
</div>

<div class="cards">
    <div class="cards__container" id="grid-mensajes">
    </div>
</div>