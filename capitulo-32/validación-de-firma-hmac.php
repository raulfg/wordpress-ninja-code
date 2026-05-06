function mi_plugin_handle_stripe_webhook( WP_REST_Request $request ): WP_REST_Response
{
    $payload   = $request->get_body();
    $signature = $request->get_header( 'stripe-signature' );
    $secret    = get_option( 'mi_plugin_stripe_webhook_secret' );

    if ( ! mi_plugin_verify_stripe_signature( $payload, $signature, $secret ) ) {
        return new WP_REST_Response( [ 'error' => 'Invalid signature' ], 401 );
    }

    $event = json_decode( $payload, true );

    switch ( $event['type'] ) {
        case 'payment_intent.succeeded':
            mi_plugin_process_payment( $event['data']['object'] );
            break;

        case 'customer.subscription.deleted':
            mi_plugin_cancel_subscription( $event['data']['object'] );
            break;
    }

    return new WP_REST_Response( [ 'received' => true ], 200 );
}

function mi_plugin_verify_stripe_signature( string $payload, string $header, string $secret ): bool
{
    // Stripe incluye timestamp y firma en el header, separados por coma
    $parts     = [];
    $timestamp = '';
    $signatures = [];

    foreach ( explode( ',', $header ) as $part ) {
        [ $key, $value ] = explode( '=', $part, 2 );
        if ( 't' === $key ) {
            $timestamp = $value;
        } elseif ( 'v1' === $key ) {
            $signatures[] = $value;
        }
    }

    // Rechazar eventos con más de 5 minutos de antigüedad (protección contra replay attacks)
    if ( empty( $timestamp ) || abs( time() - (int) $timestamp ) > 300 ) {
        return false;
    }

    $signed_payload = $timestamp . '.' . $payload;
    $expected       = hash_hmac( 'sha256', $signed_payload, $secret );

    foreach ( $signatures as $sig ) {
        if ( hash_equals( $expected, $sig ) ) {
            return true;
        }
    }

    return false;
}
