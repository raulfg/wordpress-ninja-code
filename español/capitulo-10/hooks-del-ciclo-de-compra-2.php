// Validar el checkout antes de crear el pedido
add_action( 'woocommerce_checkout_process', function(): void {
    if ( ! is_user_logged_in() ) {
        return;
    }

    $user_id = get_current_user_id();
    $limite  = (int) get_user_meta( $user_id, '_ninja_pedidos_mes', true );

    if ( $limite >= 5 ) {
        wc_add_notice(
            __( 'Has alcanzado el límite de 5 pedidos por mes.', 'ninjatheme' ),
            'error'
        );
    }
} );

// Guardar campos personalizados del checkout
add_action( 'woocommerce_checkout_update_order_meta', function(
    int $order_id, array $data
): void {
    if ( ! empty( $_POST['campo_personalizado'] ) ) {
        $pedido = wc_get_order( $order_id );
        $pedido->update_meta_data(
            '_ninja_campo_personalizado',
            sanitize_text_field( wp_unslash( $_POST['campo_personalizado'] ) )
        );
        $pedido->save();
    }
}, 10, 2 );
