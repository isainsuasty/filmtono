<footer class="footer">
    <div class="footer__grid">
        <div class="footer__content">
            <img class="footer__logo" src="/build/img/logo.svg" alt="logo" loading="lazy">
            <p><?php echo tt('footer_description'); ?></p>
        </div>

        <div class="footer__links">
            <h4><?php echo tt('footer_services'); ?></h4>
            <a href="song-licensing" class="footer__link">
                <?php echo tt('footer_services-1'); ?>
            </a>
            <a href="" class="footer__link footer__link--disabled">
                <?php echo tt('footer_services-2'); ?>
            </a>
            <a href="" class="footer__link footer__link--disabled">
                <?php echo tt('footer_services-3'); ?>
            </a>
            <a href="/prices" class="footer__link footer__link--disabled">
                <?php echo tt('footer_services-4'); ?>
            </a>
        </div>

        <div class="footer__links">
            <h4><?php echo tt('footer_music_ind'); ?></h4>
            <a href="/register-music?type=artista" class="footer__link">
                <?php echo tt('footer_music_ind-1'); ?>
            </a>
            <a href="/register-music?type=sello" class="footer__link">
                <?php echo tt('footer_music_ind-2'); ?>
            </a>
            <a href="/register-music?type=agregador" class="footer__link">
                <?php echo tt('footer_music_ind-3'); ?>
            </a>
            <a href="/register-music?type=productor" class="footer__link">
                <?php echo tt('footer_music_ind-4'); ?>
            </a>
        </div>

        <div class="footer__links">
            <h4><?php echo tt('footer_aud_ind'); ?></h4>
            <a href="/film-director" class="footer__link">
                <?php echo tt('footer_aud_ind-1'); ?>
            </a>
            <a href="/music-supervisor" class="footer__link">
                <?php echo tt('footer_aud_ind-2'); ?>
            </a>
            <a href="/audiovisual-producer" class="footer__link">
                <?php echo tt('footer_aud_ind-3'); ?>
            </a>
            <a href="content-creator" class="footer__link">
                <?php echo tt('footer_aud_ind-4'); ?>
            </a>
        </div>

        <div class="footer__links">
            <h4><?php echo tt('footer_resources'); ?></h4>
            <a href="/about" class="footer__link">
                <?php echo tt('footer_resources-1'); ?>
            </a>
            <a href="/faq" class="footer__link">
                <?php echo tt('footer_resources-2'); ?>
            </a>
            <a href="contact" class="footer__link">
                <?php echo tt('footer_resources-3'); ?>
            </a>
        </div>

        <div class="footer__links">
            <h4><?php echo tt('footer_legal'); ?></h4>
            <a href="/terms-conditions" class="footer__link">
                <?php echo tt('footer_legal-1'); ?>
            </a>
            <a href="/privacy" class="footer__link">
                <?php echo tt('footer_legal-2'); ?>
            </a>
        </div>

    </div>

    <div class="footer__social">
        
        <div class="footer__social__links">
            <a href="" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="" target="_blank">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
        </div>
        <p class="footer__social--copyright"><?php echo tt('footer_rights'); ?> &#174; Filmtono <?php echo date('Y'); ?></p>
    </div>
</footer>