function ninjatheme_wc_breadcrumbs(): void {
    if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
        return;
    }

    $args = [
        'delimiter'   => ' <span class="breadcrumb-sep">/</span> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'ninjatheme' ),
    ];

    woocommerce_breadcrumb( $args );
}
