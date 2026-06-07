// Incorrect pattern: 'init' may run before WooCommerce loads
add_action( 'init', function(): void {
    if ( function_exists( 'wc_get_product' ) ) { // This fails if WC has not loaded yet
        add_filter( 'woocommerce_product_tabs', 'npe_add_portfolio_tab' );
    }
} );

// Correct pattern: use the WooCommerce hook directly
add_action( 'woocommerce_init', function(): void {
    add_filter( 'woocommerce_product_tabs', 'npe_add_portfolio_tab' );
} );

// Or use the check on the latest available hook
add_action( 'wp_loaded', function(): void {
    // At wp_loaded, all plugins are loaded
    if ( class_exists( 'WooCommerce' ) ) {
        add_filter( 'woocommerce_product_tabs', 'npe_add_portfolio_tab' );
    }
} );
