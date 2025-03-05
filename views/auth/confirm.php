<main class="container">
    <div class="auth">        
        <h1 class="auth__heading">{%<?php echo $titulo; ?>%}</h1>

        <?php
            require_once __DIR__ . '/../templates/alertas.php';
        ?>
        
        <?php
        if(isset($alertas['exito'])){ ?>
            <i class="auth__icon fa-regular fa-circle-check"></i>
        <?php } else{
            if(isset($alertas['error'])){ ?>
                <i class="auth__icon--fail fa-regular fa-circle-xmark"></i>
                <p class="auth__text">{%auth_confirm_paragraph_error%}</p>
            <?php 
        } }?> 
        
        <?php
            if(isset($alertas['exito'])){ ?>
                <div class="acciones--centrar">
                    <a href="/login" class="btn-submit">{%auth_confirm_login_btn%}</a>
                </div>
        <?php } ?>
    </div>
</main>