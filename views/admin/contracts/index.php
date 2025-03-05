<h1>{%contracts_main-title%}</h1>

<div class="dashboard__total">
    <p>
        <span>{%contracts_total%}:</span>
        <?php echo count($contratosMusical) + count($contratosArtistico);?>
    </p>
    <div class="flex">
        <p>
            <span>{%contracts_type-music%}:</span>
            <?php echo count($contratosMusical);?>
        </p>
        <p>
            <span>{%contracts_type-artistic%}:</span>
            <?php echo count($contratosArtistico);?>
        </p>
    </div>

    <div class="dashboard__search">
        <input class="dashboard__total__type-search" type="text" id="contratos-search" placeholder="Buscar..."/>
    </div>
</div>

<div class="cards">
    <div class="cards__container" id="contracts-container">
    </div>
</div>