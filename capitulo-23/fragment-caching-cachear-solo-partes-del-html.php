function renderizar_menu_principal(): string {
    $clave  = 'menu_principal_html';
    $grupo  = 'fragmentos';
    $html   = wp_cache_get( $clave, $grupo );

    if ( false !== $html ) {
        return $html;
    }

    ob_start();
    wp_nav_menu( [
        'theme_location' => 'primary',
        'menu_class'     => 'nav-principal',
    ] );
    $html = ob_get_clean();

    wp_cache_set( $clave, $html, $grupo, 12 * HOUR_IN_SECONDS );

    return $html;
}
