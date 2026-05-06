// Antes de añadir al carrito — puede bloquear la acción
add_filter( 'woocommerce_add_to_cart_validation', function(
    bool $passed, int $product_id, int $quantity, int $variation_id = 0
): bool {
    $producto = wc_get_product( $product_id );

    // Bloquear si el cliente ya tiene este producto en el carrito
    foreach ( WC()->cart->get_cart() as $item ) {
        if ( $item['product_id'] === $product_id ) {
            wc_add_notice(
                __( 'Este producto ya está en tu carrito.', 'ninjatheme' ),
                'error'
            );
            return false;
        }
    }

    return $passed;
}, 10, 4 );

// Después de añadir al carrito
add_action( 'woocommerce_add_to_cart', function(
    string $cart_item_key, int $product_id, int $quantity
): void {
    // Registrar evento para analítica, actualizar contadores, etc.
    do_action( 'ninja_product_added_to_cart', $product_id, $quantity );
}, 10, 3 );
