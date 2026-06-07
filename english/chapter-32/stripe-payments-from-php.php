<?php

add_action( 'wp_ajax_my_plugin_create_payment_intent', function (): void {
    check_ajax_referer( 'my_plugin_payment', 'nonce' );

    $amount   = absint( $_POST['amount'] ?? 0 );
    $currency = sanitize_text_field( $_POST['currency'] ?? 'eur' );

    if ( $amount <= 0 ) {
        wp_send_json_error( 'Invalid amount', 400 );
    }

    \Stripe\Stripe::setApiKey( get_option( 'my_plugin_stripe_secret_key' ) );

    try {
        $intent = \Stripe\PaymentIntent::create(
            [
                'amount'   => $amount, // in cents
                'currency' => $currency,
                'metadata' => [ 'user_id' => get_current_user_id() ],
            ]
        );

        wp_send_json_success( [ 'client_secret' => $intent->client_secret ] );
    } catch ( \Stripe\Exception\ApiErrorException $e ) {
        error_log( '[my-plugin] Stripe error: ' . $e->getMessage() );
        wp_send_json_error( 'Error creating payment', 500 );
    }
} );
