<h1>{% <?php echo $titulo;?> %}</h1>

<!-- <?php //debugging($ntmusica)
;?> -->
<div class="dashboard__total">
    <p><span>{% register-labels_total %}: </span> 
        <?php echo $labelsTotal; ?>
    </p>
    <p><span>{% labels-users_total %}: </span> 
        <?php echo $labels; ?>
    </p>
    <p><span>{% publishers_total %}: </span> 
        <?php echo $publishers; ?>
    </p>
    <p><span>{% aggregators_total %}: </span> 
        <?php echo $aggregators; ?>
    </p>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="userLabel-search" placeholder="{% labels_placeholder %}"/>
    </div>
</div>

<div class="cards">
    <div class="cards__container" id="grid-userLabel">
    </div>
</div>
