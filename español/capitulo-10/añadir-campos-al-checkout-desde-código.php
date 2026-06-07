// Añadir el campo
add_filter( 'woocommerce_checkout_fields', function( array $fields ): array {
    $fields['billing']['ninja_cif'] = [
        'type'        => 'text',
        'label'       => __( 'CIF / NIF', 'ninjatheme' ),
        'placeholder' => __( 'B12345678', 'ninjatheme' ),
        'required'    => false,
        'class'       => [ 'form-row-wide' ],
        'priority'    => 25, // Posición en el formulario
    ];
    return $fields;
} );

// Validar el campo
add_action( 'woocommerce_checkout_process', function(): void {
    if ( ! empty( $_POST['ninja_cif'] ) ) {
        $cif = sanitize_text_field( wp_unslash( $_POST['ninja_cif'] ) );
        if ( ! preg_match( '/^[A-Z][0-9]{8}$/', $cif ) ) {
            wc_add_notice( __( 'El CIF introducido no es válido.', 'ninjatheme' ), 'error' );
        }
    }
} );

// Guardar en el pedido
add_action( 'woocommerce_checkout_update_order_meta', function( int $order_id ): void {
    if ( ! empty( $_POST['ninja_cif'] ) ) {
        $pedido = wc_get_order( $order_id );
        $pedido->update_meta_data( '_ninja_cif', sanitize_text_field( wp_unslash( $_POST['ninja_cif'] ) ) );
        $pedido->save();
    }
} );

// Mostrar en el panel de administración del pedido
add_action( 'woocommerce_admin_order_data_after_billing_address', function( WC_Order $order ): void {
    $cif = $order->get_meta( '_ninja_cif' );
    if ( $cif ) {
        echo '<p><strong>' . esc_html__( 'CIF / NIF:', 'ninjatheme' ) . '</strong> ' . esc_html( $cif ) . '</p>';
    }
} );
