<?php
/**
 * header.php — NinjaTheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header id="site-header" class="site-header">
    <div class="site-branding">
        <?php if ( has_custom_logo() ) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-link" rel="home">
                <?php bloginfo( 'name' ); ?>
            </a>
        <?php endif; ?>

        <?php
        $description = get_bloginfo( 'description' );
        if ( $description ) :
        ?>
            <p class="site-description"><?php echo esc_html( $description ); ?></p>
        <?php endif; ?>
    </div>

    <nav id="primary-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Menú principal', 'ninjatheme' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
        ] );
        ?>
    </nav>
</header>
