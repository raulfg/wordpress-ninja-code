// Hook fired when WooCommerce marks an order as completed
add_action( 'woocommerce_order_status_completed', function( int $order_id ): void {
    $order = wc_get_order( $order_id );
    $user_id = $order->get_user_id();

    if ( ! $user_id ) {
        return; // Guest order — enroll on account registration
    }

    foreach ( $order->get_items() as $item ) {
        // The '_llms_course_id' meta is set by the LifterLMS + WooCommerce addon
        $course_id = wc_get_order_item_meta( $item->get_id(), '_llms_course_id', true );

        if ( $course_id ) {
            llms_enroll_student( $user_id, (int) $course_id, 'woocommerce_order_' . $order_id );
        }
    }
} );
