// In header.php
do_action( 'ninjatheme_before_header' );
?>
<header class="site-header" <?php ninjatheme_header_schema(); ?>>
    <?php
    do_action( 'ninjatheme_header_open' );
    ?>
    <div class="site-header__inner">
        <?php do_action( 'ninjatheme_header_start' ); ?>

        <div class="site-branding">
            <?php ninjatheme_site_branding(); ?>
        </div>

        <?php do_action( 'ninjatheme_header_navigation' ); ?>

        <?php do_action( 'ninjatheme_header_end' ); ?>
    </div>
    <?php do_action( 'ninjatheme_header_close' ); ?>
</header>
<?php
do_action( 'ninjatheme_after_header' );
