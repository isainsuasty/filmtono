<h1>{% <?php echo $titulo;?> %}</h1>

<div class="dashboard__total">
    <p><span>{% music_labels-total %}: </span> 
        <?php echo count($sellos); ?>
    </p>    

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="sellos-search" placeholder="{% music_labels_search-placeholder %}"/>
    </div>
</div>

<p>{%music_labels-subtitle%}</p>

<a href="/music/labels/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {% music_labels_add-btn %}
</a>

<div class="cards">
    <div class="cards__container" id="grid-sellos">
    </div>
</div>
