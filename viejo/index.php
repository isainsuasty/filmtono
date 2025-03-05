<?php
    @require 'includes/functions.php';
    includeTemplate('header', $inicio = true);
?>

<main class="container slider-main">
    <div class="wrapper">
        <div class="slider">

            <!-- <img class="leftImg" src="" alt="imagen galería">
            <img class="mainImg" src="" alt="imagen galería">
            <img class="rightImg"src="" alt="imagen galería"> -->

        </div>

        <div class="buttons">
            <button class="slider-next">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
            <button class="slider-prev">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>
        <!-- <ul class="puntos">
                <li class="punto"></li>
                <li class="punto"></li>
        </ul>  -->
    </div>

</main>

<!--sección de playlist inicial-->
<div class="container slider-main">
    <?php
    $playlist=[
        'Canción número 1' => 'LALUQNpm4zk',
        'Canción número 2' => 'EVLFwbyLX3A',
        'Canción número 3' => 'g5JAOnrmjQg',
        'Canción número 4' => '5SodqEc8mAc',
        'Canción número 5' => 'MqrScuLXoSo',
        'Canción número 6' => 'a2DSskFgT5E',
        'Canción número 7' => 'GZ9ic9QSO5U',
        'Canción número 8' => 'y3MWfPDmVqo',
        'Canción número 9' => 'a2DSskFgT5E',
        'Canción número 10' => 'GZ9ic9QSO5U',
        'Canción número 11' => 'y3MWfPDmVqo'
    ];
    
    ?>
    
    <div class="light-bg">
        <div class="wrapper">
            <h2 class="playlist-title">Top</h2>

            <div class="ft-playlist">   

                <div class="ft-songs">            
                    <?php foreach($playlist as $nombre => $id):?>
                    
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id;?> ">
                        <button type="submit" class="playlist-btn">
                            <img src="build/img/play-btn.svg"/>
                        <?php echo $nombre; ?>
                        </button>
                    </form>
                    <?php endforeach;?>
                </div>
                
                <iframe class="ft-player" width="560" height="315" src='https://www.youtube.com/embed/<?php echo empty($_POST['id']) ? $playlist['Canción número 1'] :$_POST['id'].'?autoplay=1&mute=1'?>' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" autoplay muted="muted" allowfullscreen></iframe>

            </div>

            <div class="ft-playlist">   

                <div class="ft-songs">            
                    <?php foreach($playlist as $nombre => $id):?>
                    
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id;?> ">
                        <button type="submit" class="playlist-btn">
                            <img src="build/img/play-btn.svg"/>
                        <?php echo $nombre; ?>
                        </button>
                    </form>
                    <?php endforeach;?>
                </div>
                
                <iframe class="ft-player" width="560" height="315" src='https://www.youtube.com/embed/<?php echo empty($_POST['id']) ? $playlist['Canción número 1'] : $_POST['id'] ;?>' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            </div>
        </div>

        <div class="buttons">
            <button class="slider-next">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
            <button class="slider-prev">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>
    </div>   
</div>

<!--Sección de categorías-->
<div class="container slider-main">
    <div class="wrapper">
        <div class="main-container">
            <h2>Categorias</h2>
            <div class="categories">
                <div class="cat-info">
                    <p>Electrónica</p>
                </div>
                <div class="cat-info">
                    <p>Verano 2022</p>
                </div>
                <div class="cat-info">
                    <p>Reggae</p>
                </div>
                <div class="cat-info">
                    <p>Pop</p>
                </div>
                <div class="cat-info">
                    <p>R&B</p>
                </div>
                <div class="cat-info">
                    <p>Salsa</p>
                </div>
            </div>
        </div>

        <div class="main-container">
            <h2>Instrumentos</h2>
            <div class="categories">
                <div class="cat-info">
                    <p>Violín</p>
                </div>
                <div class="cat-info">
                    <p>Trompeta</p>
                </div>
                <div class="cat-info">
                    <p>Maracas</p>
                </div>
                <div class="cat-info">
                    <p>Timbales</p>
                </div>
                <div class="cat-info">
                    <p>Bajo</p>
                </div>
                <div class="cat-info">
                    <p>Piano</p>
                </div>
            </div>
        </div>

        <div class="main-container">
            <h2>Sensaciones</h2>
            <div class="categories">
                <div class="cat-info">
                    <p>Felicidad</p>
                </div>
                <div class="cat-info">
                    <p>Angustia</p>
                </div>
                <div class="cat-info">
                    <p>Tristeza</p>
                </div>
                <div class="cat-info">
                    <p>Miedo</p>
                </div>
                <div class="cat-info">
                    <p>Ternura</p>
                </div>
                <div class="cat-info">
                    <p>Maternidad</p>
                </div>
            </div>
        </div>

        <div class="main-container">
            <h2>Categorias</h2>
            <div class="categories">
                <div class="cat-info">
                    <p>Electrónica</p>
                </div>
                <div class="cat-info">
                    <p>Verano 2022</p>
                </div>
                <div class="cat-info">
                    <p>Reggae</p>
                </div>
                <div class="cat-info">
                    <p>Pop</p>
                </div>
                <div class="cat-info">
                    <p>R&B</p>
                </div>
                <div class="cat-info">
                    <p>Salsa</p>
                </div>
            </div>
        </div>

        <div class="main-container">
            <h2>Instrumentos</h2>
            <div class="categories">
                <div class="cat-info">
                    <p>Violín</p>
                </div>
                <div class="cat-info">
                    <p>Trompeta</p>
                </div>
                <div class="cat-info">
                    <p>Maracas</p>
                </div>
                <div class="cat-info">
                    <p>Timbales</p>
                </div>
                <div class="cat-info">
                    <p>Bajo</p>
                </div>
                <div class="cat-info">
                    <p>Piano</p>
                </div>
            </div>
        </div>

        <div class="main-container">
            <h2>Sensaciones</h2>
            <div class="categories">
                <div class="cat-info">
                    <p>Felicidad</p>
                </div>
                <div class="cat-info">
                    <p>Angustia</p>
                </div>
                <div class="cat-info">
                    <p>Tristeza</p>
                </div>
                <div class="cat-info">
                    <p>Miedo</p>
                </div>
                <div class="cat-info">
                    <p>Ternura</p>
                </div>
                <div class="cat-info">
                    <p>Maternidad</p>
                </div>
            </div>
        </div>
    </div>

    <div class="buttons">
        <button class="slider-next">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
        <button class="slider-prev">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>
</div>

<!-- <section class="container slider-main">
    <div class="wrapper">-->
        <!-- <div class="main-container artista">
            <video width="320" height="240" loop autoplay muted controls>
                <source src="/build/videos/guitar_string3.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <h2>C-tangana</h2>
        </div> -->
        <!-- <div class="main-container artista">
            <h2>C-Tangana</h2>
        </div>
        <div class="main-container artista">
            <h2>C-Tangana</h2>
        </div>
        <div class="main-container artista">
            <h2>C-Tangana</h2>
        </div>
        <div class="main-container artista">
            <h2>C-Tangana</h2>
        </div>
        <div class="main-container artista">
            <h2>C-Tangana</h2>
        </div>
    </div>
    <div class="buttons">
        <button class="slider-next">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
        <button class="slider-prev">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>
</section> -->

<section class="div-bg">
    <div class="container slider-main">
    <h1 class="text-left">Artistas</h1>
        <div class="wrapper">
        
            <a href="artista.php">
                <div class="artista">
                    <div id="player0" name="vp" onmouseover="Mouseover(this)" onmouseout="Mouseout(this)" videoId="uV0r4a2QVkQ">
                    </div>
                    <h3>C-Tangana<span>&rightarrow;</span></h3>
                </div>
            </a>

            <div class="artista">
                <div id="player1" name="vp" onmouseover="Mouseover(this)" onmouseout="Mouseout(this)" videoId="sGIm0-dQd8M">
                </div>
                <h3>Daddy Yankee<span>&rightarrow;</span></h3>
            </div>

            <div class="artista">
                <div id="player2" name="vp" onmouseover="Mouseover(this)" onmouseout="Mouseout(this)" videoId="I9t4XTOwtEo">
                </div>
                <h3>Systema Solar<span>&rightarrow;</span></h3>
            </div>
        
            <div class="artista">
                <div id="player3" name="vp" onmouseover="Mouseover(this)" onmouseout="Mouseout(this)" videoId="ozXIAg7zp9I">
                </div>
                <h3>Rawayana<span>&rightarrow;</span></h3>
            </div>  

        </div>

        <div class="buttons">
            <button class="slider-next">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
            <button class="slider-prev">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>
    </div>
</section>


<script src="//www.youtube.com/player_api"></script>
<!-- <div class="container">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/pOv9oHD4TDA?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div> -->

<?php
    includeTemplate('footer');
?>
