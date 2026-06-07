function ninjatheme_setup(): void {
    // Delega la generación del <title> a WordPress.
    // Sin esto, tienes que construir el título manualmente en header.php.
    add_theme_support( 'title-tag' );

    // Activa las imágenes destacadas en posts y páginas.
    // Sin esta declaración, the_post_thumbnail() no genera output.
    add_theme_support( 'post-thumbnails' );

    // Registra ubicaciones de menú que el usuario puede gestionar
    // desde Apariencia > Menús.
    register_nav_menus( [
        'primary'   => __( 'Menú principal', 'ninjatheme' ),
        'footer'    => __( 'Menú de pie de página', 'ninjatheme' ),
    ] );

    // Indica a WordPress que use markup HTML5 en los elementos
    // que genera automáticamente: formularios de búsqueda,
    // galerías, comentarios. Sin esto, genera HTML4.
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Añade automáticamente <link> de RSS en el <head>.
    add_theme_support( 'automatic-feed-links' );

    // Compatibilidad con WooCommerce.
    // Sin esta declaración, WooCommerce muestra un aviso de que el
    // tema no es compatible y usa sus propias plantillas de fallback.
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'ninjatheme_setup' );
