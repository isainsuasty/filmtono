<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="<?php
            sesionActiva();
        ?>" class="dashboard__enlace <?php pagina_admin('dashboard');?>">
            <i class="fas fa-home dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_index'); ?>
            </span>
        </a>
        
        <a href="/music/profile" class="dashboard__enlace <?php pagina_admin('profile');?>">
            <i class="fa-solid fa-user dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_profile'); ?>
            </span>
        </a>

        <?php
            if($_SESSION['nivel_musica'] == '2'):?>
                <a href="/music/labels" id="labels" class="dashboard__enlace <?php pagina_admin('labels'); regBtn();?>">
                    <i class="fa-solid fa-certificate dashboard__icono"></i>
                    <span class="dashboard__menu-texto">
                        <?php echo tt('sidebar_labels'); ?>
                    </span>
                </a>
            <?php endif;
        ?>

        <a href="/music/albums" id="music" class="dashboard__enlace <?php pagina_admin('albums'); pagina_admin('singles'); regBtn();?>">
            <i class="fa-solid fa-compact-disc dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_music');?>
            </span>
        </a>

        <a href="/music/artists" id="artists" class="dashboard__enlace <?php pagina_admin('artists'); regBtn();?>">
            <i class="fa-solid fa-microphone-lines dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_artists');?>
            </span>
        </a>

        <a href="/music/company" class="dashboard__enlace <?php pagina_admin('company'); regBtn();?>">
            <i class="fa-solid fa-location-dot dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_company'); ?>
            </span>
        </a>
    </nav>
</aside>