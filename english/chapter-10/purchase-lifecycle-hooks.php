// Before adding to cart — can block the action
add_filter( 'woocommerce_add_to_cart_validation', function(
    bool $passed, int $product_id, int $quantity, int $variation_id = 0
): bool {
    $product = wc_get_product( $product_id );

    // Block if the customer already has this product in the cart
    foreach ( WC()->cart->get_cart() as $item ) {
        if ( $item['product_id'] === $product_id ) {
            wc_add_notice(
                __( 'This product is already in your cart.', 'ninjatheme' ),
                'error'
            );
            return false;
        }
    }

    return $passed;
}, 10, 4 );

// After adding to cart
add_action( 'woocommerce_add_to_cart', function(
    string $cart_item_key, int $product_id, int $quantity
): void {
    // Log event for analytics, update counters, etc.
    do_action( 'ninja_product_added_to_cart', $product_id, $quantity );
}, 10, 3 );
