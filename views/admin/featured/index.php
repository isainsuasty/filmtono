<h1>{%admin_featured_title%}</h1>

<div class="dashboard__total">
    <p>
        <span>{%admin_featured_total%}:</span>
        <?php echo count($featured);?>
    </p>
</div>

<a href="/filmtono/featured/new" class="btn-submit">
    <i class="fa-solid fa-plus"></i>
    {%admin_featured_new-btn%}
</a>

<div class="cards">
    <div class="cards__container" id="cards-container">
        <?php foreach($featured as $song):?>
            <div class="card">
                <iframe class="card__video" src="https://www.youtube.com/embed/<?php echo $song->videoId?>?&autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <div class="card__info">
                    <p class="card__info__title"><?php echo $song->title?></p>
                </div>
                <div class="card__acciones">
                    <a href="/filmtono/featured/edit?id=<?php echo $song->id;?>" class="btn-update">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <button id="eliminar" class="btn-delete" data-role="filmtono" data-item="featured" value="<?php echo $song->id;?>">
                    <i class="fa-solid fa-trash-can no-click"></i>
                </button>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
