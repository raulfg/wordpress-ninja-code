// Hook que se dispara cuando WooCommerce marca un pedido como completado
add_action( 'woocommerce_order_status_completed', function( int $order_id ): void {
    $order = wc_get_order( $order_id );
    $user_id = $order->get_user_id();

    if ( ! $user_id ) {
        return; // Pedido de invitado — matricular al registrar la cuenta
    }

    foreach ( $order->get_items() as $item ) {
        // El meta '_llms_course_id' lo establece el addon LifterLMS + WooCommerce
        $course_id = wc_get_order_item_meta( $item->get_id(), '_llms_course_id', true );

        if ( $course_id ) {
            llms_enroll_student( $user_id, (int) $course_id, 'woocommerce_order_' . $order_id );
        }
    }
} );
