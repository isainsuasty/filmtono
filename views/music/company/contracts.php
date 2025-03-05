<h1>{% <?php echo $titulo;?> %}</h1>

<a href="/music/company" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%company_back-btn%}
</a>

<div class="flex--gap-3">
    <div class="block light-bg">
        <h1 class="mBottom-5 mTop-1">{%contract_music%}</h1>

        <div class="pdf-container">
            <iframe width=100% height=700 id="pdf" src="/contracts/<?php echo $contratoMusical->nombre_doc?>" frameborder="0"></iframe>
        </div>
    </div>

    <?php
        if(isset($contratoArtistico)):?>
    <div class="block light-bg">
        <h1 class="mBottom-5 mTop-1">{%contract_artistic%}</h1>
        <div class="pdf-container">
            <iframe width=100% height=700 id="pdf" src="/contracts/<?php echo $contratoArtistico->nombre_doc?>" frameborder="0"></iframe>
        </div>
    </div>
    <?php endif;?>
</div>