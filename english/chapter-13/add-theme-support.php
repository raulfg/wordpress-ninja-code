function ninjatheme_setup(): void {
    // Delegates <title> generation to WordPress.
    // Without this, you have to build the title manually in header.php.
    add_theme_support( 'title-tag' );

    // Enables featured images on posts and pages.
    // Without this declaration, the_post_thumbnail() produces no output.
    add_theme_support( 'post-thumbnails' );

    // Registers menu locations that the user can manage
    // from Appearance > Menus.
    register_nav_menus( [
        'primary'   => __( 'Primary menu', 'ninjatheme' ),
        'footer'    => __( 'Footer menu', 'ninjatheme' ),
    ] );

    // Tells WordPress to use HTML5 markup in the elements
    // it generates automatically: search forms,
    // galleries, comments. Without this, it generates HTML4.
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Automatically adds RSS <link> in the <head>.
    add_theme_support( 'automatic-feed-links' );

    // WooCommerce compatibility.
    // Without this declaration, WooCommerce displays a warning that the
    // theme is not compatible and uses its own fallback templates.
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'ninjatheme_setup' );
