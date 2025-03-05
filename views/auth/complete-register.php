<h1>{%auth_complete-register_title%}</h1>

<p></p>

<div id="tabs" class="tabs">
    <nav class="tabs__nav">
        <div class="tabs__nav__line"></div>
        <button type="button" data-paso="1" class="tab__button active">1</button>
        <button type="button" data-paso="2" class="tab__button">2</button>
        <button type="button" data-paso="3" class="tab__button">3</button>
    </nav>
    <p class="form__info">{% p-required_fields %}</p>

    <form method="POST">
        <div id="paso-1" class="tabs__section mostrar">
            <h3>1. {% t-personal_data %}</h3>
            <h4>{% t-complete_your_data %}</h4>
            <div class="form--registro">
                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="nombre">
                        <i class="fa-solid fa-user-check form--registro__group__icon"></i>
                        {% i-name %}
                    </label>
                    <input class="form--registro__group__input"            type="text"
                        id ="nombre"
                        name="nombre"
                        value="<?php echo $usuario->nombre.' '.$usuario->apellido; ?>"
                        disabled
                    >
                </div>
                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="email">
                        <i class="fa-solid fa-envelope-circle-check form--registro__group__icon"></i>
                        {% i-email %}
                    </label>
                    <input class="form--registro__group__input" type="email"
                        id="email"
                        name="email"
                        value="<?php echo $usuario->email; ?>"
                        disabled
                    >
                </div>
                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="cargo">
                        <i class="fa-solid fa-briefcase form--registro__group__icon"></i>
                        {% i-position %} *
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="cargo"
                            id="cargo"
                            placeholder="{% i-position %}"
                            value=""
                    >
                </div>
                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="pais_contacto">
                        <i class="fa-solid fa-earth-americas form--registro__group__icon"></i>
                        {% i-your_country %} *
                    </label>
                    <select class="form--registro__group__select" name="pais_contacto" id="pais_contacto">
                        <option selected disabled value="0">{% i-select_country %} *</option>
                    </select>
                    <input type="hidden" name="pais_contacto_name" id="pais_contacto_name" value="">
                </div>
                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="tel_contacto">                        
                        <i class="fa-solid fa-mobile-screen form--registro__group__icon"></i>
                        {% i-phone %} *
                    </label>
                    <div class="tel-form">                        
                        <input class="form--registro__group__input tel-input" type="tel"
                                name="tel_contacto"
                                id="tel_contacto"
                                placeholder="{% i-phone %}"
                                value=""
                        >
                        <input type="text" name="tel-index" id="tel-index" class="tel-index" placeholder="+" value="" readonly>
                    </div>
                </div>                
            </div>
        </div>

        <div id ="paso-2" class="tabs__section">
            <h3>2. {%t-about_company%}</h3>
            <h4>{%t-company_data%}</h4>
            <div class="form--registro">
                <div class="form--registro__group">             
                    <label class="form--registro__group__label" for="empresa">
                        <i class="fa-regular fa-building form--registro__group__icon"></i>
                        {%i-company_name%} *
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="empresa"
                            id="empresa"
                            placeholder="{%i-company_name%}"
                            value=""
                    >
                </div>

                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="id_fiscal">
                        <i class="fa-solid fa-landmark form--registro__group__icon"></i>
                        {%i-fiscal_id%} *
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="id_fiscal"
                            id="id_fiscal"
                            placeholder="{%i-fiscal_id%}"
                            value=""
                    >
                </div>

                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="pais">
                        <i class="fa-solid fa-earth-americas form--registro__group__icon"></i>
                        {%i-country%} *
                    </label>
                    <select class="form--registro__group__select" name="pais" id="pais">
                        <option selected disabled value="0">{%i-select_country%} *</option>
                    </select>
                </div>

                <div class="form--registro__group">
                    <label class="form--registro__group__label" for="direccion">
                        <i class="fa-solid fa-location-dot form--registro__group__icon"></i>
                        {%i-address%} *
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="direccion"
                            id="direccion"
                            placeholder="{%i-address%}"
                            value=""
                    >
                </div>
            </div>

            <h4>{%t-purchase_contact%}</h4>
            <div class="form--registro">            
                <div class="form--registro_group">
                    <label class="form--registro__group__label" for="nombre_compras">
                        <i class="fa-solid fa-user-plus form--registro__group__icon"></i>
                        {%i-name%}
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="nombre_compras"
                            id="nombre_compras"
                            placeholder="{%i-name%}"
                            value=""
                    >
                </div>
                <div class="form--registro_group">
                    <label class="form--registro__group__label" for="apellido_compras">
                        <i class="fa-solid fa-user-plus form--registro__group__icon"></i>
                        {%i-last_name%}
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="apellido_compras"
                            id="apellido_compras"
                            placeholder="{%i-last_name%}"
                            value=""
                    >
                </div>
                <div class="form--registro_group">
                    <label class="form--registro__group__label" for="email_compras">
                        <i class="fa-solid fa-at form--registro__group__icon"></i>
                        {%i-email%}
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="email_compras"
                            id="email_compras"
                            placeholder="{%i-email%}"
                            value=""
                    >
                </div>
                <div class="form--registro_group">
                    <label class="form--registro__group__label" for="tel_compras">
                        <i class="fa-solid fa-mobile-screen form--registro__group__icon"></i>
                        {%i-phone%}
                    </label>
                    <input class="form--registro__group__input" type="text"
                            name="tel_compras"
                            id="tel_compras"
                            placeholder="{%i-phone%}"
                            value=""
                    >
                </div>
            </div>
        </div>

        <div id="paso-3" class="tabs__section">
            <h3>3. {%t-signs_authorizations%}</h3>
            <div class="tabs__auth">
                <div class="tabs__auth__bloque">
                    <i class="tabs__help fa-solid fa-circle-info"></i>
                    <p>{%p-sign_music_contract%} *</p>
                    <p class="tabs__help--info">{%p-info_music_contract%}</p>
                    <button type="button" class="btn-tabs btn-contrato" id="contrato-musical">{%b-read_sign%}</button>
                    <p class="tabs__help--confirm" id="confirm-contrato"></p>
                </div>
                <div class="tabs__auth__bloque">
                    <i class="tabs__help fa-solid fa-circle-info"></i>
                    <p>{%p-sign_artistic_contract%}</p>
                    <p class="tabs__help--info">{%p-info_artistic_contract%}</p>
                    <button type="button" class="btn-tabs btn-contrato btn-contrato--optional" id="contrato-artistico">{%b-read_sign%}</button>
                    <p class="tabs__help--confirm" id="confirm-contrato-art"></p>
                </div>
            </div>
            
            <h4>{%t-terms_acceptance%}</h4>
            <div class="form--registro__checkbox--div" id="div-check">
                <div class="form--registro__checkbox">
                    <input class="form--registro__checkbox__input" type="checkbox"
                            name="terms"
                            id="terms"
                            value="1"
                    >
                    <label class="form--registro__checkbox__label" for="terms">
                        <i class="fa-regular fa-file-lines form--registro__group__icon"></i>
                        {%l-i_accept_terms%} <a href="/terms-conditions" target="_blank">{%l-terms_conditions%} *</a>
                    </label>
                </div>
                <div class="form--registro__checkbox">
                    <input class="form--registro__checkbox__input" type="checkbox"
                            name="privacy"
                            id="privacy"
                            value="1"
                    >
                    <label class="form--registro__checkbox__label" for="privacy">
                        <i class="fa-regular fa-file-lines form--registro__group__icon"></i>
                        {%l-i_accept_privacy%} <a href="/privacy" target="_blank">{%l-privacy_policy%} *</a>
                    </label>
                </div>
                <div class="form--registro__checkbox">
                    <input class="form--registro__checkbox__input" type="checkbox"
                            name="comunicados"
                            id="comunicados"
                            value="1"
                    >
                    <label class="form--registro__checkbox__label" for="comunicados">
                        <i class="fa-regular fa-file-lines form--registro__group__icon"></i>
                        {%l-accept_communications%}
                    </label>
                </div>
            </div>
        </div>

        <div class="tabs__pags">
            <button type="button" id="anterior" class="btn-tabs ocultar">&#129044; {%b-previous%}</button>
            <button type="button" id="siguiente" class="btn-tabs btn-tabs--disabled">{%b-next%} &#10143;</button>
            <input type="submit" id="btn-submit" class="btn-tabs no-display" value="{%b-register%} &#10143;">
        </div>
        <input type="hidden" name="signatureInput" id="signatureInput" value="">
        <input type="hidden" name="signatureOptional" id="signatureOptional" value="">
    </form>
</div>
