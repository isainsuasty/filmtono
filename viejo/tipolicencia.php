<?php
    require 'includes/functions.php';
    includeTemplate('header')
?>

<div class="container">
    <h1>Licencias</h1>

    <div class="recuadro">
        <form method="POST" action="">

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Cine / Publicidad</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Cine Independiente / Trailer</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Pyme Publicidad</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Videojuego</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Apps</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Series Web</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>

            <a href="/regionlicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Podcast</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>


        </form>
    </div>
</div>

<?php
    includeTemplate('footer');
?>