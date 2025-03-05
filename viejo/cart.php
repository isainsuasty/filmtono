<?php
    require 'includes/functions.php';
    includeTemplate('header')
?>

<div class="container">
    <h1>Tu carrito</h1>

    <div class="recuadro">
        <form method="POST" action="">
            <div class="songs">
                <div class="songs-btn">
                    <img src="build/img/play-btn.svg"/>
                    <p>Canción X - Artista Y</p>
                </div>
                <a href="/formlicencia.php">¿Qué uso le vas a dar?</a>                
            </div>

            <div class="songs">
                <div class="songs-btn">
                    <img src="build/img/play-btn.svg"/>
                    <p>Canción A - Artista X</p>
                </div>
                <a href="/formlicencia.php">¿Qué uso le vas a dar?</a>                
            </div>

            <div class="songs">
                <div class="songs-btn">
                    <img src="build/img/play-btn.svg"/>
                    <p>Canción B- Artista L</p>
                </div>
                <a href="/formlicencia.php">¿Qué uso le vas a dar?</a>                
            </div>


            <div class="bloque-btn">
                <button class="btn-compra">
                    Realizar pedido
                </button>
            </div>

        </form>
    </div>
</div>

<?php
    includeTemplate('footer');
?>