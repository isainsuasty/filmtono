<?php
    if($contratoMusical == null || $contratoArtistico == null): ?>
        <div class="light-bg mTop-0 mBottom-5" id="firmar-contratos-dashboard">
            <span class="auth__text--post--mobile only--mobile">
                {%dashboard_sign_mobile%}
            </span>
            <div class="tabs__auth">
                <?php if($contratoMusical == null): ?>
                <div class="tabs__auth__bloque">
                    <p class="center text-green title-info mBottom-0">{%contract_music%}</p>
                    <p>{%dashboard_sign_music-p%} *</p>
                    <p class="tabs__help--info">{%p-info_music_contract%}</p>
                    <button type="button" class="btn-tabs btn-contrato only--desktop" id="music" data-u="<?php echo $usuario->id?>">{%b-read_sign%}</button>
                </div>
                <?php endif ?>
                <?php if($contratoArtistico == null): ?>
                <div class="tabs__auth__bloque mTop-5--only-mobile">
                    <p class="center text-green title-info mBottom-0">{%contract_artistic%}</p>
                    <p>{%dashboard_sign_artistic-p%}</p>
                    <p class="tabs__help--info">{%p-info_artistic_contract%}</p>
                    <button type="button" class="btn-tabs btn-contrato btn-contrato--optional only--desktop" id="artistic" data-u="<?php echo $usuario->id?>">{%b-read_sign%}</button>
                </div>
                <?php endif ?>
            </div>
        </div>
<?php endif ?>

<h1>{%dashboard-title%}</h1>

<h2>{% music_dashboard-subtitle %}</h2>

