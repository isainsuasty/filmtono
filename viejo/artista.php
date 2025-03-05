<?php
    require 'includes/functions.php';
    includeTemplate('header')
?>

<main class="container artistaDiv">
    <div id="player1" name="vp" onmouseover="Mouseover(this)" onmouseout="Mouseout(this)" videoId="sGIm0-dQd8M">
    </div>

    <h1>Daddy Yankee</h1>

    
    
    <div class="artistaInfo">
        <div class="bio">
            <h2>Biografía del artista<h2>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet a excepturi soluta accusamus ducimus odit aut quisquam eos at ratione ad, pariatur corrupti sunt hic nam illo? Architecto, ad deserunt.
            Impedit maiores inventore aliquid tenetur, recusandae eaque optio sit quam provident numquam quis dolores explicabo nisi rerum fuga. Debitis voluptatum distinctio modi voluptas esse vel quidem architecto eveniet! Fugiat, odit?
            Sint, provident culpa hic quaerat blanditiis dolores rerum nihil esse suscipit id aspernatur dolore illo consequatur sequi maiores ullam fugit! Ratione magnam accusantium ut modi provident quibusdam quidem? Placeat, ratione?
            Ex esse deleniti aut eos hic architecto corrupti nostrum, veniam magnam asperiores perspiciatis sunt eligendi quis, dolorum dignissimos. Corporis corrupti voluptate illo maxime necessitatibus non accusamus ratione ipsam sapiente eligendi.
            Quam animi impedit sint explicabo repudiandae, itaque nisi tempore aliquam sed voluptates culpa molestiae soluta quisquam porro? Beatae nulla qui eum magni consequatur ea repellendus quidem nisi unde, ipsa molestias.</p>
        </div>
        <div class="artistaRedes">
            <h2>Redes sociales</h2>
            <div class="redesIconos">
                <i class="fa fa-facebook"></i>
                <i class="fa fa-twitter"></i>
                <i class="fa fa-instagram"></i>
                <i class="fa fa-youtube"></i>
            </div>
            <a class="patrocinar" href="">Patrocinar</a>
        </div>
    </div>
</main>

<section class="container light-bg">
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

            <div class="artist-playlist">   

                <div class="artist-songs">            
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
                
                <iframe class="artist-player" width="560" height="315" src='https://www.youtube.com/embed/<?php echo empty($_POST['id']) ? $playlist['Canción número 1'] :$_POST['id'].'?autoplay=1&mute=1'?>' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" autoplay muted="muted" allowfullscreen></iframe>

            </div>

        </div>
    </div>  
</section>

<?php
    includeTemplate('footer');
?>