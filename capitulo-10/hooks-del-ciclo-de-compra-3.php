// Acción al completar un pedido
add_action( 'woocommerce_order_status_completed', function( int $order_id ): void {
    $pedido    = wc_get_order( $order_id );
    $cliente   = $pedido->get_user();

    if ( ! $cliente ) {
        return;
    }

    // Asignar membresía al cliente si compró el producto correcto
    foreach ( $pedido->get_items() as $item ) {
        if ( $item->get_product_id() === NINJA_MEMBRESIA_PRO_ID ) {
            ninja_activate_membership( $cliente->ID, 'pro' );
        }
    }
} );

// Hook genérico: estado anterior → estado nuevo
add_action( 'woocommerce_order_status_changed', function(
    int $order_id, string $old_status, string $new_status, WC_Order $order
): void {
    if ( 'processing' === $new_status ) {
        // El pago fue recibido — enviar email personalizado, actualizar inventario externo, etc.
    }
}, 10, 4 );
