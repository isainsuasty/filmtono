<h1>{% <?php echo $titulo;?> %}</h1>

<a href="/music/company/contracts" class="btn-back">{%contracts_all-btn%}</a>

<div class="form-div">
    <form class="form" method="POST" enctype="multipart/form-data">

<?php
    require_once __DIR__ . '/../../templates/alertas.php';
?>
    <legend class="form__legend">{% company_form_edit-company %}</legend>
        <div class="form__group">
            <label class="form__group__label" for="empresa">
                <i class="fa-regular fa-building form--registro__group__icon"></i>
                {% company_form_company-name_label %}
            </label>                
            <input class="form__group__input" type="text" name="empresa" value="<?php echo $empresa->empresa?>" id="empresa" placeholder="{%company_form_company-name_placeholder%}">
        </div>

        <div class="form__group">
            <label class="form__group__label" for="id_fiscal">
                <i class="fa-solid fa-landmark form--registro__group__icon"></i>
                {%company_form_fiscal_id_label%}                
            </label>                
            <input class="form__group__input" type="text" name="id_fiscal" value="<?php echo $empresa->id_fiscal?>" id="id_fiscal" placeholder="{%company_form_fiscal_id_placeholder%}">
        </div>

        <div class="form__group">
            <label class="form__group__label" for="pais">
                <i class="fa-solid fa-earth-americas form--registro__group__icon"></i>
                {%company_form_country_label%}
            </label>
            <select class="form__group__select" name="pais" id="pais">
                <option id="current-pais" class="current-value" selected value="<?php echo $empresa->pais;?>">{%company_form_country_placeholder%}</option>
            </select>
        </div>

        <div class="form__group">
            <label class="form__group__label" for="direccion">
                <i class="fa-solid fa-location-dot form--registro__group__icon"></i>
                {%company_form_address_label%}
        </label>
            <input class="form__group__input" type="text" name="direccion" id="direccion" value="<?php echo $empresa->direccion;?>" placeholder="{%company_form_address_placeholder%}">
        </div>

        <div class="form__group">
            <label class="form__group__label" for="cargo">
                <i class="fa-solid fa-briefcase form--registro__group__icon"></i>
                {%company_form_position_label%}
            </label>
            <input class="form__group__input" type="text"
                    name="cargo"
                    id="cargo"
                    placeholder="company_form_position_placeholder"
                    value="<?php echo $empresa->cargo;?>"
            >
        </div>

        <legend class="form__legend">{%company_form_edit_purchase%}</legend>    
        <div class="form_group">
            <label class="form__group__label" for="nombre_compras">
                <i class="fa-solid fa-user-plus form--registro__group__icon"></i>
                {%company_form_purchase_name_label%}
            </label>
            <input class="form__group__input" type="text"
                    name="nombre_compras"
                    id="nombre_compras"
                    placeholder="{%company_form_purchase_name_placeholder%}"
                    value="<?php echo $empresa->nombre_compras;?>"
            >
        </div>

        <div class="form--registro_group">
            <label class="form__group__label" for="apellido_compras">
                <i class="fa-solid fa-user-plus form--registro__group__icon"></i>
                {%company_form_purchase_lastname_label%}
            </label>
            <input class="form__group__input" type="text"
                    name="apellido_compras"
                    id="apellido_compras"
                    placeholder="{%company_form_purchase_lastname_placeholder%}"
                    value="<?php echo $empresa->apellido_compras;?>"
            >
        </div>

        <div class="form_group">
            <label class="form__group__label" for="email_compras">
                <i class="fa-solid fa-at form--registro__group__icon"></i>
                {%company_form_purchase_email_label%}
            </label>
            <input class="form__group__input" type="text"
                    name="email_compras"
                    id="email_compras"
                    placeholder="{%company_form_purchase_email_placeholder%}"
                    value="<?php echo $empresa->email_compras;?>"
            >
        </div>
        <div class="form_group">
            <label class="form__group__label" for="tel_compras">
                <i class="fa-solid fa-mobile-screen form--registro__group__icon"></i>
                {%company_form_purchase_phone_label%}
            </label>
            <input class="form__group__input" type="text"
                    name="tel_compras"
                    id="tel_compras"
                    placeholder="{%company_form_purchase_phone_placeholder%}"
                    value="<?php echo $empresa->tel_compras;?>"
            >
        </div>
        
        <div class="acciones">
            <input class="btn-submit--form" type="submit" value="{%company_form_save-btn%}">
            <button id="eliminar-cuenta" data-item="company" data-role="music" class="btn-delete btn-delete--form" value="<?php echo $empresa->id;?>">
                <i class="fa-solid fa-trash-can no-click"></i>
                {%company_form_delete-btn%}
            </button>
        </div>
    </form>
</div>