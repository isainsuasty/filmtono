<header class="header">
    <div class="header__bar">
        <div class="header__left">
            <a class="header__link--logo" href="/">
                <img class="header__left--logo" src="/build/img/logo.svg" alt="Logo Filmtono" loading="lazy">
            </a>
            <a class="header__link--back" href="javascript: history.go(-1)">
                <i class="fas fa-arrow-left header__left--arrow <?php echo $inicio ? 'no-display' : '' ;?>"></i>
            </a>
        
            <a href="/search" class="header__left__label">
                <p><?php echo tt('nav_search'); ?></p>
                <img class="btn-search" src="/build/img/search-bar.svg" loading="lazy">
            </a>
        </div>

        <div class="header__lang">
            <div class="header__select no-display" id="language">
                <button class="btn-lang" value="en">English</button>
                <button class="btn-lang" value="es">Español</button>
            </div>
        </div>

        <div class="header__login">
            <?php if(isset($_SESSION['id'])): ?>
                <form class="dashboard__form" action="/logout" method="POST">
                    <input class="header__login__btn--login"type="submit" value="<?php echo tt('nav_logout'); ?>">
                </form>
                <a class="header__login__btn--signup" href="<?php sesionActiva()?>"><?php echo tt('nav_admin'); ?></a>
            <?php else: ?>
            <a class="header__login__btn--login" href="/login"><?php echo tt('nav_login'); ?></a>
            <a class="header__login__btn--signup" href="/register"><?php echo tt('nav_signup'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</header>