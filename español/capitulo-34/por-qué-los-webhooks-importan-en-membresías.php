function ninja_handle_stripe_webhook( WP_REST_Request $request ): WP_REST_Response {
    $payload   = $request->get_body();
    $sig_header = $request->get_header( 'stripe-signature' );
    $secret    = get_option( 'ninja_stripe_webhook_secret' );

    try {
        $event = \Stripe\Webhook::constructEvent( $payload, $sig_header, $secret );
    } catch ( \Stripe\Exception\SignatureVerificationException $e ) {
        return new WP_REST_Response( [ 'error' => 'Firma inválida' ], 400 );
    }

    switch ( $event->type ) {
        case 'customer.subscription.created':
            ninja_on_subscription_created( $event->data->object );
            break;

        case 'customer.subscription.deleted':
            ninja_on_subscription_deleted( $event->data->object );
            break;

        case 'invoice.payment_failed':
            ninja_on_payment_failed( $event->data->object );
            break;
    }

    return new WP_REST_Response( [ 'received' => true ] );
}
