function ninjatheme_wc_breadcrumbs(): void {
    if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
        return;
    }

    $args = [
        'delimiter'   => ' <span class="breadcrumb-sep">/</span> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="Ruta de navegación">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Inicio', 'breadcrumb', 'ninjatheme' ),
    ];

    woocommerce_breadcrumb( $args );
}
