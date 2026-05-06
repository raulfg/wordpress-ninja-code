// Patrón incorrecto: 'init' puede ejecutarse antes de que WooCommerce cargue
add_action( 'init', function(): void {
    if ( function_exists( 'wc_get_product' ) ) { // Esto falla si WC no ha cargado aún
        add_filter( 'woocommerce_product_tabs', 'npe_add_portfolio_tab' );
    }
} );

// Patrón correcto: usar el hook de WooCommerce directamente
add_action( 'woocommerce_init', function(): void {
    add_filter( 'woocommerce_product_tabs', 'npe_add_portfolio_tab' );
} );

// O usar la verificación en el hook más tardío disponible
add_action( 'wp_loaded', function(): void {
    // En wp_loaded, todos los plugins están cargados
    if ( class_exists( 'WooCommerce' ) ) {
        add_filter( 'woocommerce_product_tabs', 'npe_add_portfolio_tab' );
    }
} );
