// Action on order completion
add_action( 'woocommerce_order_status_completed', function( int $order_id ): void {
    $order    = wc_get_order( $order_id );
    $customer = $order->get_user();

    if ( ! $customer ) {
        return;
    }

    // Assign membership to the customer if they bought the right product
    foreach ( $order->get_items() as $item ) {
        if ( $item->get_product_id() === NINJA_MEMBRESIA_PRO_ID ) {
            ninja_activate_membership( $customer->ID, 'pro' );
        }
    }
} );

// Generic hook: previous status → new status
add_action( 'woocommerce_order_status_changed', function(
    int $order_id, string $old_status, string $new_status, WC_Order $order
): void {
    if ( 'processing' === $new_status ) {
        // Payment was received — send custom email, update external inventory, etc.
    }
}, 10, 4 );
