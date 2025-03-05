<?php
    require 'includes/functions.php';
    includeTemplate('header')
?>

<div class="container">
    <h1>Tu carrito</h1>

    <div class="recuadro">
        <form method="POST" action="">
            <div class="radio">
                <label class="label">Nacional 
                <input id="name" class="block mt-1 w-full" type="radio" name="region"/>
                <span class="checkmark"></span>
                </label>
            </div>
            <div class="radio">
                <label  class="label">Internacional
                <input id="name" class="block mt-1 w-full" type="radio" name="region"/>
                <span class="checkmark"></span>
                </label>
            </div>

            <div class="bloque-btn">
                <a href="/formlicencia.php" class="botones">
                    Continuar
                </a>
            </div>

        </form>
    </div>
</div>

<?php
    includeTemplate('footer');
?>