add_action( 'wp_ajax_mi_plugin_create_payment_intent', function (): void {
    check_ajax_referer( 'mi_plugin_payment', 'nonce' );

    $amount   = absint( $_POST['amount'] ?? 0 );
    $currency = sanitize_text_field( $_POST['currency'] ?? 'eur' );

    if ( $amount <= 0 ) {
        wp_send_json_error( 'Importe inválido', 400 );
    }

    \Stripe\Stripe::setApiKey( get_option( 'mi_plugin_stripe_secret_key' ) );

    try {
        $intent = \Stripe\PaymentIntent::create(
            [
                'amount'   => $amount, // en céntimos
                'currency' => $currency,
                'metadata' => [ 'user_id' => get_current_user_id() ],
            ]
        );

        wp_send_json_success( [ 'client_secret' => $intent->client_secret ] );
    } catch ( \Stripe\Exception\ApiErrorException $e ) {
        error_log( '[mi-plugin] Stripe error: ' . $e->getMessage() );
        wp_send_json_error( 'Error al crear el pago', 500 );
    }
} );
