// Validate the checkout before creating the order
add_action( 'woocommerce_checkout_process', function(): void {
    if ( ! is_user_logged_in() ) {
        return;
    }

    $user_id = get_current_user_id();
    $limit   = (int) get_user_meta( $user_id, '_ninja_pedidos_mes', true );

    if ( $limit >= 5 ) {
        wc_add_notice(
            __( 'You have reached the limit of 5 orders per month.', 'ninjatheme' ),
            'error'
        );
    }
} );

// Save custom checkout fields
add_action( 'woocommerce_checkout_update_order_meta', function(
    int $order_id, array $data
): void {
    if ( ! empty( $_POST['campo_personalizado'] ) ) {
        $order = wc_get_order( $order_id );
        $order->update_meta_data(
            '_ninja_campo_personalizado',
            sanitize_text_field( wp_unslash( $_POST['campo_personalizado'] ) )
        );
        $order->save();
    }
}, 10, 2 );
