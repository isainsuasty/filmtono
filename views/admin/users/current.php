<a href="/filmtono/users" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
    {%users_back-btn%}
</a>

<h1><?php echo $usuario->nombre. ' '. $usuario->apellido;?></h1>

<h2 class="text-yellow text-left mTop-5 mBottom-0"> {%t-personal_data%}</h2>
<div class="grid-2">
    <div class="block">
        <p><span class="text-blue">{%t-type-user%}: </span>
            <?php 
            if($ntadmin){
                echo 'Admin';
            } else if($ntmusica){
                if($_SESSION['lang'] === 'en'){
                        echo $tipoMusica->tipo_en;
                    } else{
                        echo $tipoMusica->tipo_es;
                    }
                } else{
                    echo '{%t-user-without-type%}';
                }
                ?>
            </p>

        <p><span class="text-blue">{%t-email%}: </span><?php echo $usuario->email; ?></p>

        <?php if($usuario->confirmado === '0'): ?>
            <p><span class="text-blue">{%t-confirmed%}: </span>{%t-no%}</p>
        <?php else: ?>
            <p><span class="text-blue">{%t-confirmed%}: </span>{%t-yes%}</p>
        <?php endif; ?>

        <?php if(!$ntadmin): ?>
            <?php if($usuario->perfil === '0'): ?>
                <p><span class="text-blue">{%t-profile%}: </span>{%t-profile-incomplete%}</p>
            <?php else: ?>
                <p><span class="text-blue">{%t-profile%}: </span>{%t-profile-complete%}</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php if($empresa) :?>
    <div class="block">
        <p><span class="text-blue">{%i-position%}: </span><?php echo $empresa->cargo; ?></p>
        <p><span class="text-blue">{%t-contact_phone%}: </span><?php echo $empresa->tel_contacto; ?></p>
        <p><span class="text-blue">{%t-contact_country%}: </span>
            <span class="pais-value" id="<?php echo $empresa->pais_contacto; ?>"></span>
        </p>
    </div>
</div>

<h2 class="text-yellow text-left mTop-3 mBottom-0"> {%t-company_data%}</h2>
<div class="grid-2">
    <div class="block">
        <p><span class="text-blue">{%i-company_name%}: </span><?php echo $empresa->empresa; ?></p>
        <p><span class="text-blue">{%i-fiscal_id%}: </span><?php echo $empresa->id_fiscal; ?></p>
        <p><span class="text-blue">{%i-address%}: </span><?php echo $empresa->direccion; ?></p>
        <p><span class="text-blue">{%t-country%}: </span>
            <span class="pais-value" id="<?php echo $empresa->pais; ?>"></span>
        </p>
    </div>
    <div class="block">
        <p><span class="text-blue">{%t-purchase_name%}: </span><?php echo $empresa->nombre_compras.' '.$empresa->apellido_compras; ?></p>
        <p><span class="text-blue">{%t-purchase_email%}: </span><?php echo $empresa->email_compras; ?></p>
        <p><span class="text-blue">{%t-purchase_phone%}: </span><?php echo $empresa->tel_compras; ?></p>
    </div>
<?php endif; ?>
</div>

<button class="btn-delete" value="<?php echo $usuario->id ?>" data-role="filmtono" data-item="users"><i class="fa-solid fa-trash-can no-click"></i></button>