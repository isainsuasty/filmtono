<div class="container">

<?php switch($userType):
    case 'artista': ?>
        <h1 class="text-yellow">{%register_artist-title-1%}</h1>
        <p>{%register_artist-p-1%}<p>

        <h1>{%register_artist-title-2%}</h1>
        <p>{%register_artist-p-2%}<p>
        <p>{%register_artist-p-3%}<p>
        <ul>
            <li>{%t-inempresarios%}</li>
        </ul>
        <?php break;

        case 'sello': ?>
        <h1>{%register_label-title-1%}</h1>
        <p>{%register_label-p-1%}<p>
        <p>{%register_label-p-2%}<p>
        <p>{%register_label-p-3%}<p>

        <h1>{%register_label-title-2%}</h1>
        <p>{%register_label-p-4%}<p>
        <?php break;

        case 'agregador': ?>
            <h1>{%register_aggregator-title-1%}</h1>
            <p>{%register_aggregator-p-1%}<p>
            <p>{%register_aggregator-p-2%}<p>
            <p>{%register_aggregator-p-3%}<p>

            <h1>{%register_aggregator-title-2%}</h1>
            <p>{%register_aggregator-p-4%}<p>
            <?php break;
            
        case 'productor': ?>
            <h1>{%register_producer-title-1%}</h1>
            <p>{%register_producer-p-1%}<p>
            <p>{%register_producer-p-2%}<p>
            <?php break;
        default: ?>
            <?php break;
    endswitch; ?>

    <?php
        if($userType !== 'artista'):
            require_once __DIR__ . '/form.php';
        endif;
    ?>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6LdErd0pAAAAAH6zMR7aF0fP9CAZpZDWCC0EKpFU"></script>

<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LdErd0pAAAAAH6zMR7aF0fP9CAZpZDWCC0EKpFU', {action: 'submit'}).then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
    });
});
</script>