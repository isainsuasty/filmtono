<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="<?php
            sesionActiva();
        ?>" class="dashboard__enlace <?php pagina_admin('dashboard');?>">
            <i class="fas fa-home dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_index');?>
            </span>
        </a>

        <a href="/filmtono/profile" class="dashboard__enlace <?php pagina_admin('profile');?>">
            <i class="fa-solid fa-user dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_profile');?>
            </span>
        </a>

        <a href="/filmtono/promos" class="dashboard__enlace <?php pagina_admin('promos');?>">
            <i class="fa-solid fa-photo-film dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_promos');?>
            </span>
        </a>

        <a href="/filmtono/featured" class="dashboard__enlace <?php pagina_admin('featured');?>">
            <i class="fa-solid fa-radio dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_featured');?>
            </span>
        </a>

        <a href="/filmtono/users" class="dashboard__enlace <?php pagina_admin('users');?>">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_users');?>
            </span>
        </a>
        
        <a href="/filmtono/labels" class="dashboard__enlace <?php pagina_admin('labels');?>">
            <i class="fa-solid fa-certificate dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_labels');?>
            </span>
        </a>

        <a href="/filmtono/categories" class="dashboard__enlace <?php pagina_admin('categories');?>">
            <i class="fa-solid fa-box-archive dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_categories');?>
            </span>
        </a>

        <a href="/filmtono/albums" class="dashboard__enlace <?php pagina_admin('albums');?>">
            <i class="fa-solid fa-compact-disc dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_music');?>
            </span>
        </a>

        <a href="/filmtono/artists" class="dashboard__enlace <?php pagina_admin('artists');?>">
            <i class="fa-solid fa-face-grin-stars dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_artists');?>
            </span>
        </a>

        <a href="/filmtono/languages" class="dashboard__enlace <?php pagina_admin('languages');?>">
            <i class="fa-solid fa-language dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_languages');?>
            </span>
        </a>

        <a href="/filmtono/contracts" class="dashboard__enlace <?php pagina_admin('contracts');?>">
            <i class="fa-solid fa-file-signature dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_contracts');?>
            </span>
        </a>

        <a href="/filmtono/messages" class="dashboard__enlace <?php pagina_admin('messages');?>">
            <i class="fa-solid fa-address-card dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                <?php echo tt('sidebar_messages');?>
            </span>
        </a>
    </nav>
</aside>