<header class="dashboard__header">
    <div class="dashboard__header-grid">
        <div class="dashboard__saludo">
            <a href="/">
                <img class="dashboard__logo" src="/build/img/logo.svg" loading="lazy" alt="logo">
            </a>

            <h3 class="dashboard__titulo"><?php echo tt('nav_hello').' '.$_SESSION['nombre'].'!'; ?></h3>
        </div>

        <nav class="dashboard__nav">
            <div class="header__lang">
                <div class="header__select no-display" id="language">
                    <button class="btn-lang" value="en">English</button>
                    <button class="btn-lang" value="es">Español</button>
                </div>
            </div>

            <form class="dashboard__form" action="/logout" method="POST">
                <input class="dashboard__submit--logout" type="submit" value="<?php echo tt('nav_logout'); ?>"/>
            </form>
        </nav>
    </div>
</header>